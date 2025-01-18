<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-label">Tambah Transaksi Reumbers</h3>
            </div>
            <div class="card-body">
                <form id="formAddReumbers" autocomplete="off">
                    <div class="form-group row">
                        <label class="col-md-3">Nomor</label>
                        <div class="col-md-4">
                            <input type="text" class="form-control" name="nomor" id="nomor">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-3">Keterangan</label>
                        <div class="col-md-6">
                            <input type="text" class="form-control" name="keterangan" id="keterangan">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-3">User</label>
                        <div class="col-md-4">
                            <select name="akunUser" id="akunUser" class="form-control">
                                <option value="0"></option>
                                @foreach($mStaff as $staff)
                                    <option value="{{$staff->idm_sales}}|{{$staff->sales_name}}">{{$staff->sales_name}} (Sales)</option>
                                @endforeach
                                @foreach($mAdmin as $admin)
                                    <option value="{{$admin->id}}|{{$admin->name}}">{{$admin->name}} (Admin)</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-3">Tipe Reumbers</label>
                        <div class="col-md-4">
                            <select name="typeReumbers" id="typeReumbers" class="form-control">
                                <option value="1|Pengembalian Dana">Pengembalian Dana</option>
                                <option value="2|Dana Pribadi">Menggunakan Dana Pribadi</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row" style="display: none;">
                        <label class="col-md-3">Dari Dana</label>
                        <div class="col-md-9">
                            <select name="fromAkunDana" id="fromAkunDana" class="form-control">
                                <option value="0"></option>
                                @foreach($akunTrs as $ats)
                                    <option value="{{$ats->idtr_kas}}">{{$ats->description}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-3">Nominal</label>
                        <div class="col-md-6">
                            <input type="text" class="form-control price-text" name="nominal" id="nominal">
                        </div>
                    </div>
                    <div class="form-group row">
                        <button type="submit" class="btn btn-success font-weight-bold">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    $(function(){
        $('.price-text').mask('000.000.000', {
            reverse: true
        });
    })
    $(document).ready(function(){
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        
        $("form#formAddReumbers").submit(function(event){
            event.preventDefault();
            var loadDiv = "listInputBarang";
            $("#btnFormPenyesuaian").fadeOut('slow');
            $.ajax({
                url: "{{route('trxReumbers')}}/postTransaksiReumbers",
                type: 'POST',
                data: new FormData(this),
                async: true,
                cache: true,
                contentType: false,
                processData: false,
                success: function (data) {
                    alertify.success('Data berhasil ditambahkan!');
                    loadDisplay(loadDiv)
                }
            });
            return false;
        });

        function disInputBarang() {
            let display = "tableReumbers";
            $("#displayNotif").fadeIn("slow");
            $.ajax({
                type : 'get',
                url : "{{route('trxReumbers')}}/"+display,
                success : function(response){
                    $('#displayLap').html(response);
                    $("#displayNotif").fadeOut("slow");
                }
            });
        }  
    });
</script>