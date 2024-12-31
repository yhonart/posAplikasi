<div class="card">
    <div class="card-header">
        <h3 class="card-title">Setup Kredit Customer</h3>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-6 col-md-3">
                <div class="form-group">
                    <label class="form-label">Cari Nama Pelanggan</label>
                    <select class="form-control select-pelanggan" id="setupPilihPelanggan" class="form-control ">
                        <option value="0" readonly>Nama Pelanggan</option>
                        @foreach($dbMCustomer as $dcs1)
                        <option value="{{$dcs1->idm_customer }}">{{$dcs1->customer_store}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div id="displaySetupPelanggan"></div>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {    
        let namaPelanggan = '0';
        
        $("#setupPilihPelanggan").change(function(){
            $("#displayNotif").fadeIn("slow");
            let namaPelanggan = $(this).find(":selected").val();
            displaySetupcustomer(namaPelanggan);
        });

        function displaySetupcustomer(namaPelanggan){
            $.ajax({
                type : 'get',
                url : "{{route('adminPiutangPelanggan')}}/setupPelanggan/"+namaPelanggan,
                success : function(response){
                    $('#displaySetupPelanggan').html(response);
                    $("#displayNotif").fadeOut("slow");
                }
            });
        }
    });
</script>