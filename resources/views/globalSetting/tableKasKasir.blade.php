<?php
    $no = '1';
?>
<table class="table table-sm table-valign-middle table-bordered">
    <thead class="bg-gradient-purple">
        <tr>
            <th>No</th>
            <th>User Kasir</th>
            <th>Nominal</th>
            <th>#</th>
        </tr>
    </thead>
    <tbody>
        @foreach($tbKasKasir as $tkk)
            <td>{{$no++}}</td>
            <td>{{$tkk->personal_id}}</td>
            <td>Rp. {{number_format($tkk->nominal,'0',',','.')}}</td>
            <td class="text-right">
                <button type="button" class="btn btn-sm btn-info btn-flat" disabled>Edit</button>
                <button type="button" class="btn btn-sm btn-danger btn-flat" disabled>Delete</button>
            </td>
        @endforeach
    </tbody>
</table>