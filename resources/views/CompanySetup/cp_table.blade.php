@extends('layouts.sidebarpage')

@section('content')
<?php
    $no = 1;
?>
<div class="content-header">
    <div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6">
        <h1 class="m-0">Pengaturan Nama Usaha</h1>
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
                    <div class="card-body text-xs">

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
                                                <td>{{$dc->company_code}}-{{$dc->idm_company}}</td>
                                                <td>{{$dc->company_name}}</td>
                                                <td>{{$dc->telefone}}</td>
                                                <td>{{$dc->location_name}}</td>
                                                <td>
                                                    @if($userHakAkses == '3')
                                                    <button type="button" id="btnDelete" class="btn btn-danger" data-id="{{$dc->idm_company}}"><i class="fa-solid fa-trash"></i> Hapus</button>
                                                    <button type="button" class="btn btn-primary BTN-OPEN-MODAL-GLOBAL-LG" href="{{route('CompanySetup')}}/companyDisplay/edit/{{$dc->idm_company}}"><i class="fa-solid fa-pen-to-square"></i> Edit</button>
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
            let el = $(this);
            let id = el.attr("data-id");
            alertify.confirm("Apakah anda yakin ingin menghapus data toko tersebut ?.",
            function(){
                $.ajax({
                    type:'get',
                    url:"{{route('CompanySetup')}}/companyDisplay/deleteToko/"+id, 
                    success : function(response){
                        window.location.reload();
                    }           
                });            
                alertify.success('Ok');
            },
            function(){
                alertify.error('Cancel');
            });
        });
    })
</script>
@endsection