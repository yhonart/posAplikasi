<div class="row">
    <div class="col-12">
        <div class="card card-info card-outline">
            <div class="card-header border-0">
                <h3 class="card-title font-weight-bold">Input Item Stock Opname</h3>
            </div>
            <div class="card-body">
                <div class="row mb-2">
                    <div class="col-12">
                        <form class="form" id="formInputOpname">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="label">No. Stock Opname</label>
                                        <input type="text" name="noStockOpname" id="noStockOpname" class="form-control form-control-sm " value="{{$firstNumber}}" readonly>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="label">Tgl. Stok Opname</label>
                                        <input type="text" name="filterTanggal" id="filterTanggal" class="form-control form-control-sm ">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="label">Lokasi Barang</label>
                                        <select class="form-control form-control-sm " name="pilihLokasi">
                                            <option value="0">Semua Lokasi</option>
                                            @foreach($mSite as $ls)
                                            <option value="{{$ls->idm_site}}">{{$ls->site_name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="label">Keterangan</label>
                                        <textarea class="form-control " rows="4" placeholder="Enter ..." name="description" id="description"></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-3">
                                    <button type="submit" class="btn btn-success font-weight-bold btn-block " id="btnFormPenyesuaian"><i class="fa-solid fa-floppy-disk"></i> Simpan Dokumen</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <p class="font-weight-bold text-muted">*NOTED</p>
                        <p class="text-muted">No. Stock opname pada form adalah nomor temporer, nomor akan tergenerate kembali menyesuaikan tanggal stock opname.</p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div id="disInputBarang"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $( function() {
        var date = new Date();
        $( "#filterTanggal" ).datepicker({
            dateFormat: 'yy-mm-dd',
            autoclose: true,
            todayHighlight: true,
            maxDate: date,
        });
        $('#filterTanggal').datepicker("setDate",new Date());
        disInputBarang();
    });
    
    $(document).ready(function(){
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        
        $("form#formInputOpname").submit(function(event){
            event.preventDefault();
            var loadDiv = "listInputBarang";
            $("#btnFormPenyesuaian").fadeOut('slow');
            $.ajax({
                url: "{{route('stockOpname')}}/submitStockOpname",
                type: 'POST',
                data: new FormData(this),
                async: true,
                cache: true,
                contentType: false,
                processData: false,
                success: function (data) {
                    // $("form#formInputOpname")[0].reset();
                    // document.getElementById("formInputOpname").style.display = "none";
                    alertify.success('Data berhasil ditambahkan!');
                    loadDisplay(loadDiv)
                }
            });
            return false;
        });
    });
    
    function disInputBarang() {
        $.ajax({
            type : 'get',
            url : "{{route('stockOpname')}}/disInputBarang",
            success : function(response){
                $('#disInputBarang').html(response);
            }
        });
    }  
    function loadDisplay(loadDiv){
        $.ajax({
            type : 'get',
            url : "{{route('stockOpname')}}/"+loadDiv,
            success : function(response){
                $('#displayOpname').html(response);
            }
        });
    }
</script>