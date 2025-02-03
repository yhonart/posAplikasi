<?php
    $dayNoww = date('l', strtotime($hariIni));
    $strHari = "Monday";
?>
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Tambah Dana Pengembalian</h3>
            </div>
            <div class="card-body">
                @if($dayNoww == $strHari)
                <form id="formAddReumbers" autocomplete="off">
                    <input type="hidden" name="lastWeekSaldo" id="lastWeekSaldo" value="{{$lastWeekSaldo}}">
                    <div class="form-group row">
                        <label class="col-md-3">Nomor</label>
                        <div class="col-md-4">
                            <input type="text" class="form-control" name="nomor" id="nomor" value="{{$thisNumber}}" readonly>
                        </div>
                    </div> 
                    <div class="form-group row" id="disAkunDana">
                        <label class="col-md-3">Sumber Dana</label>
                        <div class="col-md-9">
                            <select name="fromAkunDana" id="fromAkunDana" class="form-control">
                                <option value="0"> ==== </option>
                                @foreach($akunTrs as $ats)
                                    <option value="{{$ats->debit}}">Pendapatan Kasir {{number_format($ats->debit,'0',',','.')}}</option>
                                @endforeach
                                <option value="1">Lain-lain</option>
                            </select>
                            <span class="text-muted">* Dana diambil dari minggu lalu, mulai Tanggal : {{date("d-M-Y", strtotime($startDate))}} s.d {{date("d-M-Y", strtotime($endDate))}}</span>
                        </div>
                    </div>
                    <div class="form-group row" id="fieldBank" style="display: none;">
                        <label for="" class="col-md-3">Bank</label>
                        <div class="col-md-9">
                            <select name="namaBank" id="namaBank" class="form-control">
                                <option value="0"> ==== </option>
                                @foreach($bankOfStore as $bos)
                                <option value="{{$bos->bank_code}} xxxx{{substr($bos->account_number,5)}}">{{$bos->bank_code}} - {{$bos->account_number}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-3">Nominal</label>
                        <div class="col-md-6">
                            <input type="text" class="form-control price-text" name="nominal" id="nominal" value="{{$penguranganKas}}">
                            <span class="text-muted">* Dana diambil dari minggu lalu, mulai Tanggal : {{date("d-M-Y", strtotime($startDate))}} s.d {{date("d-M-Y", strtotime($endDate))}}</span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-3">Keterangan</label>
                        <div class="col-md-6">
                            <input type="text" class="form-control" name="keterangan" id="keterangan">
                        </div>
                    </div>
                    <div class="form-group row">
                        <button type="submit" class="btn btn-success font-weight-bold">Simpan</button>
                    </div>
                </form>
                @else
                <div class="alert alert-warning alert-dismissible">                  
                  <h5><i class="icon fas fa-info"></i> Alert!</h5>
                  Transaksi pengembalian dana kas hanya dapat di lakukan di hari <b>"Senin"</b>. Untuk dapat menambahkan dana kas kecil, 
                  silahkan gunakan form Tambah Dana di halaman Lap.Kas Kecil. 
                  <br>
                  <b>
                      Klik link berikut ini <a href="{{route('kasKecil')}}" class="btn btn-success btn-sm">Lap. Kas Kecil</a>
                  </b>
                </div>
                @endif
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
                    loadDisplay();
                }
            });
            return false;
        });

        function loadDisplay() {
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

        $("#fromAkunDana").change(function(){
            let thisSelected = $(this).find(":selected").val();
            if (thisSelected === '1') {
                $("#fieldBank").fadeIn();
            }
            else{
                $("#fieldBank").fadeOut();
            }
        }); 
    });
</script>