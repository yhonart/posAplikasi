<div class="card card-body border border-info mb-2">
    <form class="form" id="formFilterReport">
        <div class="row">
            <div class="col-md-3">
                <div class="form-group">
                    <label class="label">Produk Item</label>
                    <select class="form-control form-control-sm rounded-0" name="produk" id="produk">
                        <option value="0" readonly>Pilih Barang</option>
                        @foreach($mProduct as $mp)
                            <option value="{{$mp->idm_data_product}}">{{$mp->product_name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label class="label">Dari Tanggal</label>
                    <input class="form-control form-control-sm rounded-0 datetimepicker-input" name="fromDate" id="fromDate">
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label class="label">s/d Tanggal</label>
                    <input class="form-control form-control-sm rounded-0 datetimepicker-input" name="endDate" id="endDate">
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label class="label">Lokasi</label>
                    <select class="form-control form-control-sm rounded-0" name="lokasi" id="lokasi">
                        <option value="0" readonly>Pilih Lokasi</option>
                        @foreach($mSite as $ms)
                        <option value="{{$ms->idm_site}}">{{$ms->site_name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <button type="submit" id="submitFilter" class="btn btn-info btn-flat btn-sm"><i class="fa-solid fa-filter"></i> Filter</button>
                <button type="button" class="btn btn-flat btn-sm btn-danger" id="reportToPDF"><i class="fa-solid fa-file-pdf"></i> Cetak Kartu Stock</button>
                <div class="spinner-border spinner-border-sm text-dark" role="status" id="spinnerFilter" style="display:none;">
                  <span class="sr-only">Loading...</span>
                </div>
            </div>
        </div>
    </form>
</div>
<div class="row">
    <div class="col-md-12">        
        <div id="displayFilter"></div>
    </div>
</div>

<script>
    $(function(){
        $("#produk").select2();
        $( ".datetimepicker-input" ).datepicker({
            dateFormat: 'yy-mm-dd',
            autoclose: true,
            todayHighlight: true,
        });
        $('.datetimepicker-input').datepicker("setDate",new Date());
        let idPRD = '0';
        $.ajax({
            url: "{{route('lapInv')}}/getFilter/"+idPRD,
            type: 'GET',
            success: function (response) {                
                $("#displayFilter").html(response);
            }
        });
    });
    
    $(document).ready(function(){
        $("form#formFilterReport").submit(function(event){
            event.preventDefault();
            $("#spinnerFilter").fadeIn();
            $.ajax({
                url: "{{route('lapInv')}}/postFilter",
                type: 'POST',
                data: new FormData(this),
                async: true,
                cache: true,
                contentType: false,
                processData: false,
                success: function (data) {
                    $("#infoAwal").hide();
                    $("#displayFilter").html(data);
                    $("#spinnerFilter").fadeOut();
                }
            });
            return false;
        });

        $("#reportToPDF").on('click', function(){
            let valProduk = $("#produk").find(":selected").val(),
                valFromDate = $("#fromDate").val(),
                valEndDate = $("#endDate").val(),
                valLocation = $("#lokasi").find(":selected").val();
            window.open("{{route('lapInv')}}/downloadKartuStock/"+valProduk+"/"+valFromDate+"/"+valEndDate+"/"+valLocation,"_blank");            
        });
    });
</script>
