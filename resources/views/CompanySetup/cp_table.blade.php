@extends('layouts.sidebarpage')

@section('content')
<?php
    $no = 1;
?>
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
        @if($userHakAkses == '3')         
        <div class="row">
            <div class="col-12">                
                <button class="btn btn-primary btn-sm font-weight-bold" id="btnCreate">Tambah Nama Usaha</button>
            </div>
        </div>
        @endif
        <div class="row mt-2">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">

                        <div class="row">
                            <div class="col-md-12">
                                <div id="DisplayFormInput"></div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <table class="table table-sm table-valign-middle table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Kode Usaha</th>
                                            <th>Nama Usaha</th>
                                            <th>Telefone</th>
                                            <th>Lokasi</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($dataCompany as $dc)
                                            <tr>
                                                <td>{{$no++}}</td>
                                                <td>CPID{{$dc->idm_company}}</td>
                                                <td>{{$dc->company_name}}</td>
                                                <td>{{$dc->location_name}}</td>
                                                <td>
                                                    @if($userHakAkses == '3')
                                                    <button type="button" id="btnDelete" class="btn btn-danger"><i class="fa-solid fa-trash"></i> Hapus Toko</button>
                                                    @endif
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