<div class="card">
    <div class="card-header">
        <h3 class="card-title font-weight">Edit Transaksi</h3>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-12">
                <form class="form" id="formEditKas" autocomplete="off" enctype="multipart/form-data">
                    <input type="hidden" name="idHidden" id="idHidden" value="{{$editData->idtr_kas}}">
                    <div class="form-group row">
                        <label class="label col-md-4">Tanggal</label>
                        <div class="col-md-4">
                            <input type="text" class="form-control form-control-sm  modalDate-input" name="tanggal" id="tanggal" value="{{$editData->kas_date}}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="label col-md-4">Kategori</label>
                        <div class="col-md-4">
                            <select name="selKategori" id="selKategori" class="form-control form-control-sm  select-2">
                                <option value="{{$editData->kas_catId}}">{{$editData->cat_name}}</option>
                                @foreach($kasKategori as $kk)
                                    <option value="{{$kk->idm_cat_kas}}">{{$kk->cat_name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="label col-md-4">Sub-Kategori</label>
                        <div class="col-md-4">
                            <select name="subKategori" id="subKategori" class="form-control form-control-sm  select-2">
                                <option value="{{$editData->kas_subCatId}}">{{$editData->subcat_name}}</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="label col-md-4">Keterangan</label>
                        <div class="col-md-4">
                            <input type="text" class="form-control form-control-sm " name="keterangan" id="keterangan" value="{{$editData->description}}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="label col-md-4">Personal</label>
                        <div class="col-md-4">
                            <select name="personal" id="personal" class="form-control form-control-sm  select-2">
                                <option value="{{$editData->kas_persCode}}|{{$editData->kas_persName}}">{{$editData->kas_persName}}</option>
                                @foreach($mStaff as $ms)
                                <option value="{{$ms->sales_code}}|{{$ms->sales_name}}">{{$ms->sales_name}} (Sales)</option>
                                @endforeach
                                @foreach($mAdmin as $md)
                                <option value="{{$md->id}}|{{$md->name}}">{{$md->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="label col-md-4">nominal</label>
                        <div class="col-md-4">
                            <input type="text" class="form-control form-control-sm price-text" name="nominal" id="nominal" value="{{$editData->nominal}}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="label col-md-4">Lampiran</label>
                        <div class="col-md-3">
                            @if($editData->file_name <> "")
                                <a href="#" id="deleteLamp" class="btn btn-default border-0" data-id="{{$editData->idtr_kas}}"><i class="fa-solid fa-trash-can"></i></a>
                                <a href="{{asset('public/images/Upload/TrxKas')}}/{{$editData->file_name}}" target="_blank" rel="noopener noreferrer">{{$editData->file_name}}</a>
                            @endif
                        </div>
                        <div class="col-md-4">
                            <input type="file" name="docLampiran" id="docLampiran" class="form-control-file">
                        </div>
                    </div>
                    <div class="form-group">
                        <button class="btn btn-success  btn-sm font-weight-bold" id="btnSimpan">Simpan</button>
                        <button class="btn btn-warning  btn-sm font-weight-bold" id="btnClose">Batal</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    $(function() {
        $( ".modalDate-input" ).datepicker({
            dateFormat: 'yy-mm-dd',
            autoclose: true,
            todayHighlight: true,
        });
        $('.modalDate-input').datepicker("setDate",new Date());

        $('.select-2').select2({
            theme: 'bootstrap4',
            dropdownParent: $('#modal-global-large')
        });

        $('.price-text').mask('000.000.000', {
            reverse: true
        });
    });
    $(document).ready(function(){
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $("#selKategori").change(function(){
            let kategori = $(this).find(":selected").val();
            $.ajax({
                type : 'get',
                url : "{{route('trxKasUmum')}}/selectKategori/" + kategori,
                success : function(response){  
                    $("#subKategori").html(response);
                }
            });
        });

        $("#btnClose").click(function(){
            window.location.reload();
        });

        $("#deleteLamp").click(function(){
            alert("Oops..! fungsi ini belum dapat digunakan.")
        })

        $("form#formEditKas").submit(function(event){
            event.preventDefault();
            alertify.confirm("Apakah anda yakin ingin melakukan update dokumen ini ?",
            function(){
                $.ajax({
                    url: "{{route('trxKasUmum')}}/postTrxEditKas",
                    type: 'POST',
                    data: new FormData(this),
                    async: true,
                    cache: true,
                    contentType: false,
                    processData: false,
                    success: function (data) {                    
                        window.location.reload();
                    },                
                });
            },
            function(){
                alertify.error('Cancel');
            });
            return false;
        });
    });
</script>