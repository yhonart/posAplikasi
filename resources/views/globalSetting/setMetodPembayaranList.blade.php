<div class="row mt-2">
    <div class="col-md-6">
        <button class="btn btn-info BTN-OPEN-MODAL-GLOBAL-LG btn-flat font-weight-bold mb-2" href="{{route('setPembayaran')}}/newPembayaran">Tambah Metode Pembayaran</button>
        <div class="card card-outline card-info">
            <div class="card-header">
                <h3 class="card-title font-weight-bold">Metode Pembayaran</h3>
            </div>
            <div class="card-body">
                <table class="table table-sm table-valign-middle">
                    <thead>
                        <tr>
                            <th>Metode Pembayaran</th>
                            <th>#</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($mPayMethod as $mpm)
                            <tr>
                                <td>{{$mpm->method_name}}</td>
                                <td>
                                    <button class="btn btn-sm btn-info btn-flat BTN-OPEN-MODAL-GLOBAL-LG" href="{{route('setPembayaran')}}/editMethod/{{$mpm->idm_payment_method}}"><i class="fa-solid fa-pencil"></i></button>
                                    <button class="btn btn-sm btn-danger btn-flat DEL-METHOD" id-method="{{$mpm->idm_payment_method}}"><i class="fa-solid fa-trash"></i></button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-md-6">
    <button class="btn btn-success BTN-OPEN-MODAL-GLOBAL-LG btn-flat font-weight-bold mb-2" href="{{route('setPembayaran')}}/newAkunBank">Tambah Akun Bank</button>
        <div class="card card-outline card-success">
            <div class="card-header">
                <h3 class="card-title font-weight-bold">Bank Account</h3>
            </div>
            <div class="card-body table-responsive">
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
                                    <button class="btn btn-sm BTN-OPEN-MODAL-GLOBAL-LG btn-info btn-flat" href="{{route('setPembayaran')}}/editAkun/{{$accountBank->idm_payment}}"><i class="fa-solid fa-pencil"></i></button>
                                    <button class="btn btn-sm btn-danger btn-flat DELETE-AKUN" id-akun="{{$accountBank->idm_payment}}"><i class="fa-solid fa-trash-can"></i></button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function(){
        $('.DELETE-AKUN').on('click',function (){
            let el = $(this);
            let id = el.attr("id-akun");
            alertify.confirm("This is a confirm dialog.",
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
            alertify.confirm("This is a confirm dialog.",
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