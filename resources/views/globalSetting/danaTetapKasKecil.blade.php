@extends('layouts.sidebarpage')

@section('content')
<?php
    $no = 1;
?>
<div class="content-header">
    <div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1 class="m-0">Setup Dana Awal Kas Kecil</h1>
        </div><!-- /.col -->
    </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>

<div class="content">
    <div class="container-fluid">            
        <div class="row">
            <div class="col-12">
                <button class="btn btn-info BTN-OPEN-MODAL-GLOBAL-LG  font-weight-bold" href="{{route('modalKasKecil')}}/formAddModalFix">Setup Modal</button>
            </div>
        </div>
        <div class="row mt-2">
            <div class="col-12">
                <div class="card">
                    <div class="card-body text-xs table-responsive p-0">
                        <table class="table table-valign-middle table-hover">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Dana Tetap</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($mainDanaTetap as $mdt)
                                    <tr>
                                        <td>{{$no++}}</td>
                                        <td class="text-right">{{number_format($mdt->nominal_dana,'0',',','.')}}</td>
                                        <td>
                                            <button type="button" class="btn btn-sm btn-danger"><i class="fa-solid fa-xmark"></i></button>
                                            <button type="button" class="btn btn-sm btn-info"><i class="fa-solid fa-pencil"></i></button>
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
@endsection