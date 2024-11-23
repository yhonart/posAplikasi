<?php
    $noK = '1';
?>
<table class="table table-sm table-valign-middle table-bordered">
    <thead>
        <tr>
            <td>No.</td>
            <td>Nama Kategori</td>
            <td>Status</td>
            <td>#</td>
        </tr>
    </thead>
    <tbody>
        @foreach($loadTable as $lt)
            <tr>
                <td>{{$noK++}}</td>
                <td>{{$lt->cat_name}}</td>
                <td></td>
                <td>
                    <button class="btn btn-sm btn-info edit-kategori" data-id="{{$lt->idm_cat_kas}}"><i class="fa-solid fa-pencil"></i></button>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
<script>
    
</script>