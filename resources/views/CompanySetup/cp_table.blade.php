@extends('layouts.sidebarpage')

@section('content')
<div class="content-header">
    <div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6">
        <h1 class="m-0">Pengaturan Nama Toko/Gudang</h1>
        </div><!-- /.col -->
    </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<div class="content">
    <div class="container-fluid">            
        <div class="row">
            <div class="col-12">                
                <button class="btn btn-primary btn-sm font-weight-bold" id="btnCreate">Tambah Nama Usaha</button>
            </div>
        </div>
        <div class="row mt-2">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12 col-md-6">
                                <div id="DisplayFormInput"></div>
                            </div>
                            <div class="col-12 col-md-6">
                                @if(!empty($dataCompany))
                                <dl class="row">
                                    <dt class="col-4">Nama Usaha</dt>
                                    <dd class="col-8">: {{$dataCompany->company_name}}</dd>
                                </dl>
                                <dl class="row">
                                    <dt class="col-4">Bidang Usaha</dt>
                                    <dd class="col-8">: {{$dataCompany->company_description}}</dd>
                                </dl>
                                <dl class="row">
                                    <dt class="col-4">Alamat</dt>
                                    <dd class="col-8">: {{$dataCompany->address}}</dd>
                                </dl>
                                <dl class="row">
                                    <dt class="col-4">Owner</dt>
                                    <dd class="col-8">: {{$dataCompany->owner}}</dd>
                                </dl>
                                <dl class="row">
                                    <dt class="col-4">Contact Person</dt>
                                    <dd class="col-8">: {{$dataCompany->telefone}}</dd>
                                </dl>
                                <div class="row">
                                    <div class="col-12">
                                        <button type="button" id="btnDelete" class="btn btn-danger"><i class="fa-solid fa-trash"></i> Hapus Toko</button>
                                    </div>
                                </div>
                                @else
                                <div class="row">
                                    <div class="col-12">
                                    <div class="red-alert p-2 rounded rounded-2 notive-display">
                                        <span class="font-weight-bold">Masukkan Nama Toko.</span>
                                    </div>
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function(){               
        $('#btnCreate').on('click', function (e) {
            e.preventDefault();
            $("#DisplayFormInput").load("{{route('CompanySetup')}}/companyDisplay/add_new_cp");
        });
    })
    $(document).ready(function(){               
        $('#btnDelete').on('click', function (e) {
            e.preventDefault();
            $("#DisplayFormInput").load("{{route('CompanySetup')}}/companyDisplay/deleteToko");
            alertify.success('Success message');
            window.location.reload();
        });
    })
</script>
@endsection