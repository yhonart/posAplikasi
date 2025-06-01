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
        <table class="table table-sm table-responsive table-valign-middle">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Toko</th>
                    <th>Pemilik</th>
                    <th>Share Lock</th>
                    <th>Progress</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach($daftarKunjungan as $dk)
                    <tr>
                        <td>{{$no++}}</td>
                        <td>{{$dk->store_name}}</td>
                        <td>{{$dk->store_owner}}</td>
                        <td>Latitude:{{$dk->latitude}}, Longtitude:{{$dk->longtitude}}</td>
                        <td>{{$progress[$dk->progress]}}</td>  
                        <td></td>                      
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>