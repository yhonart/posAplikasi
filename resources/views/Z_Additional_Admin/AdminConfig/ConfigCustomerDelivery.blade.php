<div class="row">
    <div class="col-md-12">
        <div class="card card-purple">
            <div class="card-header">
                <h3 class="card-title">Pengaturan Pengiriman Barang</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">Jadwal Pengiriman Setiap Hari :</label>
                            <select name="delByDay" id="delByDay" class="form-control form-control-sm">
                                @if($countConfig >= "1")
                                    <option value="{{$selectSchedule->day_freq}}" readonly>{{$selectSchedule->day_freq}}</option>
                                @endif
                                <option value="0" readonly>== Change ==</option>
                                <option value="Senin">Senin</option>
                                <option value="Selasa">Selasa</option>
                                <option value="Rabu">Rabu</option>
                                <option value="Kamis">Kamis</option>
                                <option value="Jumat">Jumat</option>
                                <option value="Sabtu">Sabtu</option>
                                <option value="Minggu">Minggu</option>
                            </select>
                        </div>

                        <div class="form-group row" id="fieldInputFrequency" style="display: none;">
                            <label for="" class="col-md-4">Atur Berdasarkan Frequency</label>
                            <div class="col-md-4">
                                <input type="number" class="form-control form-control-sm" name="frequency" id="frequency">
                            </div>
                            <div class="col-md-4">
                                <span>Hari</span>
                            </div>
                        </div>                        

                        <div class="form-group row">
                            <div class="col-md-4">                                
                                <button type="submit" class="btn btn-success btn-sm font-weight-bold" id="simpanSchedule">Simpan</button>
                                <button type="button" class="btn btn-warning btn-sm font-weight-bold" data-dismiss="modal" aria-label="Close">
                                    Tutup
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <p class=" bg-light p-2 text-success font-weight-bold" style="display: none;" id="notifSuccess">Data Berhasil Tersimpan !</p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-body bg-gradient-blue">
                            <p>
                                Form ini digunakan untuk mengatur jadwal pengiriman ke pelanggan.
                                Pilih salah satu metode pengiriman, menggunakan jadwal hari tertentu atau menggunakan
                                frequency berapa hari sekali dalam pengiriman.
                            </p>
                            <p>
                                Jika sudah dilakukan pengaturan ini maka kurir secara otomatis akan mendapatkan jadwal pengiriman. 
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function(){
        $("#delByDay").change(function(){
            let delByDay = $(this).find(":selected").val();

            if (delByDay !== '0') {
                $("#fieldInputFrequency").fadeOut('slow');
            }
        });
        $("#simpanSchedule").on('click', function (event){
            event.preventDefault();
            $("#simpanSchedule").fadeOut();
            let getDay = $("#delByDay").val(),
                getFreq = $("#frequency").val(),
                getIdCus = "{{$idCus}}";            
            let dataForm = {getDay : getDay, getFreq : getFreq, getIdCus : getIdCus};
            $.ajax({
                type : 'post',
                url : "{{route('sales')}}/configCustomer/postConfigSchedule",
                data :  dataForm,
                success : function(data){
                    if (data.warning) {
                        alertify
                        .alert(data.warning, function(){
                            alertify.message('OK');
                        });
                    }
                    else if(data.success){
                        alertify.success(data.success);
                    }
                }
            });
        });
    });
</script>