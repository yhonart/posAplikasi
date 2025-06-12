<?php
    $no = 1;

?>
<div class="row">
    <div class="col-md-12">
        <table class="table table-sm table-valign-middle table-striped table-hover">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Product Code</th>
                    <th>Product Name</th>
                    <th>Category</th>
                    <th>Saldo</th>
                    <th>#</th>
                </tr>
            </thead>
            <tbody>
                @foreach($docInventory as $di)
                    <tr>
                        <td class="text-center">{{$no++}}</td>
                        <td class="font-weight-bold text-info">{{$di->product_code}}</td>
                        <td>{{$di->product_name}}</td>
                        <td>{{$di->product_category}}</td>
                        <td>{{$di->stock}}</td>
                        <td>
                            <button type="button" class="btn btn-info btn-sm BTN-DETAIL"><i class="fa-solid fa-magnifying-glass"></i></button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>