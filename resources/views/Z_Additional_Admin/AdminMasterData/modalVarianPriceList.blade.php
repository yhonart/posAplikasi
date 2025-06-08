<?php
    $novar = 1;
?>
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <table class="table table-sm text-xs">
                    <thead>
                        <tr>
                            <th>No.</th>    
                            <th>Code</th>
                            <th>Price</th>
                            <th>#</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($varianPriceList as $vpl)
                            <td>{{$novar++}}</td>
                            <td>{{$vpl->varian_price_code}}</td>
                            <td>{{$vpl->varian_price}}</td>
                            <td></td>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>