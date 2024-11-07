<div class="card">
    <div class="card-header">
        <h3 class="card-title">Tambah Transaksi Biaya Operasional</h3>
    </div>
    <div class="card-body">
        <div class="row p-1">
            <div class="col-md-12">
                <form class="form" id="formTambahBiaya">
                    <div class="form-group row">
                        <label class="label col-md-4">Tanggal</label>
                        <div class="col-md-4">
                            <input type="text" class="form-control form-control-sm rounded-0" name="tanggal" id="tanggal">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="label col-md-4">Kategori</label>
                        <div class="col-md-4">
                            <select name="selKategori" id="selKategori" class="form-control form-control-sm rounded-0">
                                <option value="0">===</option>
                                @foreach($kasKategori as $kk)
                                    <option value="{{$kk->idm_cat_kas}}">{{$kk->cat_name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="label col-md-4">Sub-Kategori</label>
                        <div class="col-md-4">
                            <select name="subKategori" id="subKategori" class="form-control form-control-sm rounded-0">
                                <option value="0">===</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="label col-md-4">Keterangan</label>
                        <div class="col-md-4">
                            <input type="text" class="form-control form-control-sm rounded-0" name="keterangan" id="keterangan">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="label col-md-4">Nama Karyawan</label>
                        <div class="col-md-4">
                            <select name="personal" id="personal" class="form-control form-control-sm rounded-0">
                                <option value="0"></option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="label col-md-4">nominal</label>
                        <div class="col-md-4">
                            <input type="text" class="form-control form-control-sm rounded-0" name="nominal" id="nominal">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="label col-md-4">nominal</label>
                        <div class="col-md-4">
                            <input type="file" class="form-control form-control-sm rounded-0" name="lampiran" id="lampiran">
                        </div>
                    </div>
                    <div class="form-group">
                        <button class="btn btn-success btn-flat btn-sm font-weight-bold">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
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
                url : "{{route('trxJualBeli')}}/selectKategori/" + kategori,
                success : function(response){  
                    $("#subKategori").html(response);
                }
            });
        });
    });
</script>