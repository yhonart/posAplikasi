<?php
    $no = 1;

?>
<div class="row">
    <div class="col-md-12">
        <table class="table table-sm table-valign-middle table-striped">
            <thead>
                <tr>
                    <th>No. {{$companyID}}</th>
                    <th>Product Code</th>
                    <th>Product Name</th>
                    <th>Saldo</th>
                    <th>#</th>
                </tr>
            </thead>
            <tbody>
                @foreach($docInventory as $di)
                    <tr>
                        <td>{{$no++}}</td>
                        <td>{{$di->product_code}}</td>
                        <td>{{$di->product_name}}</td>
                        <td>{{$di->stock}}</td>
                        <td></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>