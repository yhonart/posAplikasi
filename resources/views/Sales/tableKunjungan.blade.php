<?php
    $no = '1';
    $progress = array(
        1=>"Penawaran",
        2=>"Follow Up",
        3=>"Deal",
        4=>"No Deal"
    );
?>
<div class="row">
    <div class="col-md-12">
        <table class="table table-sm table-valign-middle table-responsive">
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
                        <td><b>Latitude:</b>{{$dk->latitude}}, <b>Longtitude:</b>{{$dk->longtitude}}</td>
                        <td>{{$progress[$dk->progress]}}</td>  
                        <td>
                            <a href="{{route('sales')}}/detailCustomer/{{$dk->tracking_id}}" class="btn btn-info btn-sm">Detail</a>
                        </td>                      
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>