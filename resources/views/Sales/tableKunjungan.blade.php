<?php
    $no = '1';
    $progress = array(
        1=>"Penawaran",
        2=>"Follow Up",
        3=>"Deal",
        4=>"No Deal"
    );
?>
<div class="row justify-content-center">
    <div class="col-md-12">
        <div class="card text-xs card-info">
            <div class="card-header">
                <h3 class="card-title font-weight-bold">Daftar Kunjungan</h3>
            </div>
            <div class="card-body">
                <table class="table table-sm table-valign-middle table-hover">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Toko</th>
                            <th>Pemilik</th>
                            <th>Share Lock</th>
                            <th>Progress</th>
                            <th>#</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($daftarKunjungan as $dk)
                            <tr>
                                <td>{{$no++}}</td>
                                <td>{{$dk->store_name}}</td>
                                <td>{{$dk->store_owner}}</td>
                                <td><b>Latitude:</b>{{$dk->latitude}}, <br> <b>Longtitude:</b>{{$dk->longtitude}}</td>
                                <td>{{$progress[$dk->progress]}}</td>  
                                <td class="text-right">
                                    <a href="{{route('sales')}}/detailCustomer/{{$dk->tracking_id}}" class="btn btn-outline-info btn-sm">Detail</a>
                                </td>                      
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>