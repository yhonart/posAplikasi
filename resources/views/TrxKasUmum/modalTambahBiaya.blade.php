<?php
    $saldo = 0;
?>
<div class="card card-indigo">
    <div class="card-header">
        <h3 class="card-title">Tambah Transaksi Biaya Operasional</h3>
    </div>
    <div class="card-body">
        <div class="row p-1">
            <div class="col-md-12">
                <form class="form" id="formTambahBiaya" autocomplete="off" enctype="multipart/form-data">
                    <div class="form-group row">
                        <label class="label col-md-3">Tanggal</label>
                        <div class="col-md-3">
                            <input type="text" class="form-control form-control-sm  modalDate-input" name="tanggal" id="tanggal">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="label col-md-3">Kategori</label>
                        <div class="col-md-3">
                            <select name="selKategori" id="selKategori" class="form-control form-control-sm select-2">
                                <option value="0">===</option>
                                @foreach($kasKategori as $kk)
                                    <option value="{{$kk->idm_cat_kas}}">{{$kk->cat_name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <label class="label col-md-2">Sub-Kategori</label>
                        <div class="col-md-4">
                            <select name="subKategori" id="subCategory" class="form-control form-control-sm select-2">
                                <option value="0"></option>                                
                            </select>
                        </div>
                    </div>                    
                    <div class="form-group row">
                        <label class="label col-md-3">Personal</label>
                        <div class="col-md-3">
                            <select name="personal" id="personal" class="form-control form-control-sm  select-2">
                                <option value="0|0"></option>
                                @foreach($mStaff as $ms)
                                <option value="{{$ms->sales_code}}|{{$ms->sales_name}}">{{$ms->sales_name}}/(Sales)</option>
                                @endforeach
                                @foreach($mAdmin as $md)
                                <option value="{{$md->id}}|{{$md->name}}">{{$md->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <label class="label col-md-2">No. Polisi</label>
                        <div class="col-md-4">
                            <input type="text" name="nopol" id="nopol" class="form-control form-control-sm">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="label col-md-3">nominal</label>
                        <div class="col-md-3">
                            <input type="text" class="form-control form-control-sm price-text" name="nominal" id="nominal">
                        </div>                        
                    </div>                    
                    <div class="form-group row">
                        <label class="label col-md-3">Keterangan</label>
                        <div class="col-md-9">
                            <input type="text" class="form-control form-control-sm " name="keterangan" id="keterangan">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="label col-md-3">Lampiran</label>
                        <div class="col-md-3">
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
                    $("#subCategory").html(response);
                }
            });
        });

        $("#personal").change(function(){
            let persno = $(this).find(":selected").val();
            fetch("{{route('trxKasUmum')}}/selectPersonal/" + persno)
            .then(response => response.json())
            .then(data => {                    
                if ((data.noPol)) {
                    $("#nopol").val(data.noPol);
                } else {
                    $("#nopol").val();
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
        }); 

        $("#btnClose").click(function(){
            window.location.reload();
        })

        $("form#formTambahBiaya").submit(function(event){
            event.preventDefault();
            $.ajax({
                url: "{{route('trxKasUmum')}}/postTrxPembiayaan",
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
            return false;
        });
    });
</script>