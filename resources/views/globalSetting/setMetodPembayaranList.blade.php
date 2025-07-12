<div class="row mt-2">
    <div class="col-md-6">
        @if($hakAkses == '99')
            <h3 class="text-info font-weight-bold">Pengaturan Metode Pembayaran</h3>
            <button class="btn btn-info BTN-OPEN-MODAL-GLOBAL-LG  font-weight-bold mb-2" href="{{route('setPembayaran')}}/newPembayaran">Tambah Metode Pembayaran</button>
        @endif
        <div class="card card-outline card-info">
            <div class="card-header">
                <h3 class="card-title font-weight-bold">Metode Pembayaran</h3>
            </div>
            <div class="card-body text-xs">
                <table class="table table-sm table-valign-middle">
                    <thead>
                        <tr>
                            <th>Metode Pembayaran</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($mPayMethod as $mpm)
                            <tr>
                                <td>{{$mpm->method_name}}</td>
                                <td>
                                    @if($hakAkses == '99')
                                        <button class="btn btn-sm btn-info  BTN-OPEN-MODAL-GLOBAL-LG" href="{{route('setPembayaran')}}/editMethod/{{$mpm->idm_payment_method}}"><i class="fa-solid fa-pencil"></i></button>
                                        <button class="btn btn-sm btn-danger  DEL-METHOD" id-method="{{$mpm->idm_payment_method}}"><i class="fa-solid fa-trash"></i></button>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-md-6">    
        <div class="card card-outline card-success">
            <div class="card-header">
                <h3 class="card-title font-weight-bold">Bank Account</h3>
            </div>
            <div class="card-body text-xs table-responsive">
                <div class="row">
                    <div class="col-md-6">
                        <span class="font-weight-bold">Perusahaan :</span> <br>
                        <small>{{$company}}</small>
                    </div>
                    <div class="col-md-6">
                        <span class="font-weight-bold">Hak Akses :</span> <br>
                        <small>{{$hakAkses}}</small>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <button class="btn btn-success BTN-OPEN-MODAL-GLOBAL-LG  font-weight-bold mb-2" href="{{route('setPembayaran')}}/newAkunBank">Tambah Akun Bank</button>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <table class="table table-sm table-valign-middle text-nowrap">
                            <thead>
                                <tr>
                                    <th>Kode Bank</th>
                                    <th>Nama Bank</th>
                                    <th>Nomor</th>
                                    <th>Nama Akun</th>
                                    <th>#</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($mAccountBank as $accountBank)
                                    <tr>
                                        <td>{{$accountBank->bank_code}}</td>
                                        <td>{{$accountBank->bank_name}}</td>
                                        <td>{{$accountBank->account_number}}</td>
                                        <td>{{$accountBank->account_name}}</td>
                                        <td>
                                            <button class="btn btn-sm BTN-OPEN-MODAL-GLOBAL-LG btn-info " href="{{route('setPembayaran')}}/editAkun/{{$accountBank->idm_payment}}"><i class="fa-solid fa-pencil"></i></button>
                                            <button class="btn btn-sm btn-danger  DELETE-AKUN" id-akun="{{$accountBank->idm_payment}}"><i class="fa-solid fa-trash-can"></i></button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>                
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function(){
        $('.DELETE-AKUN').on('click',function (){
            let el = $(this);
            let id = el.attr("id-akun");
            alertify.confirm("Apakah anda yakin ingin menghapus data ini ?",
            function(){
                $.ajax({
                    type:'get',
                    url:"{{route('setPembayaran')}}/deleteAkun/"+id, 
                    success : function(response){
                        window.location.reload();
                    }           
                });            
                alertify.success('Ok');
            },
            function(){
                alertify.error('Cancel');
            });
        })
        $('.DEL-METHOD').on('click',function (){
            let el = $(this);
            let id = el.attr("id-method");
            alertify.confirm("Apakah anda yakin ingin menghapus data ini ?",
            function(){
                $.ajax({
                    type:'get',
                    url:"{{route('setPembayaran')}}/deletePembayaran/"+id, 
                    success : function(response){
                        alertify.success('Ok');
                        window.location.reload();
                    }           
                });            
            },
            function(){
                alertify.error('Cancel');
            });
        })
    })
</script>