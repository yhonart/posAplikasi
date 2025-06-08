<?php
    $novar = 1;
?>
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body table-responsive table-striped table-hover" style="height: 400px;">
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
                            <tr>
                                <td>{{$novar++}}</td>
                                <td>{{$vpl->varian_price_code}}</td>
                                <td class="text-right font-weight-bold">Rp. {{number_format($vpl->varian_price,'0',',','.')}}</td>
                                <td></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>