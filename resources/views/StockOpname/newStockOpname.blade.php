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
                                        <input type="text" name="noStockOpname" id="noStockOpname" class="form-control form-control-sm rounded-0" value="{{$firstNumber}}" readonly>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="label">Tgl. Stok Opname</label>
                                        <input type="text" name="filterTanggal" id="filterTanggal" class="form-control form-control-sm rounded-0">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="label">Lokasi Barang</label>
                                        <select class="form-control form-control-sm rounded-0" name="pilihLokasi">
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
                                        <textarea class="form-control rounded-0" rows="4" placeholder="Enter ..." name="description" id="description"></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-3">
                                    <button type="submit" class="btn btn-success font-weight-bold btn-block btn-flat" id="btnFormPenyesuaian"><i class="fa-solid fa-floppy-disk"></i> Simpan Lokasi Opname</button>
                                </div>
                            </div>
                        </form>
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
        $( "#filterTanggal" ).datepicker({
            dateFormat: 'yy-mm-dd',
            autoclose: true,
            todayHighlight: true,
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
            let loadDiv = "listInputBarang";
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