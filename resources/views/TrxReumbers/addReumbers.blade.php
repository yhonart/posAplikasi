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
                            <input type="text" class="form-control" name="nomor" id="nomor" value="{{$thisNumber}}" readonly>
                        </div>
                    </div> 
                    <div class="form-group row" id="disAkunDana">
                        <label class="col-md-3">Sumber Dana Minggu Lalu</label>
                        <div class="col-md-9">
                            <select name="fromAkunDana" id="fromAkunDana" class="form-control">
                                <option value="0"> ==== </option>
                                @foreach($akunTrs as $ats)
                                    <option value="{{$ats->create_by}}|{{$ats->debit}}">{{$ats->description}} @ {{number_format($ats->debit,'0',',','.')}}</option>
                                @endforeach
                            </select>
                            <span class="text-muted">Dana diambil dari minggu lali, mulai Tanggal : {{date("d-M-Y", strtotime($startDate))}} s.d {{date("d-M-Y", strtotime($endDate))}}</span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-3">Nominal</label>
                        <div class="col-md-6">
                            <input type="text" class="form-control price-text" name="nominal" id="nominal">
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
    });
</script>