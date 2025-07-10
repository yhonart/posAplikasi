<?php
    $nomor = 1;
?>

@foreach($listPengiriman as $lpr)
    <div class="card border border-1 border-info shadow-sm">
        <div class="card-header">
            <h3 class="card-title font-weight-bold">{{$lpr->customer_store}}</h3>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-4">
                    <span class="font-weight-bold">Alamat :</span> <br>
                    <small>{{$lpr->address}}</small>
                </div>
                <div class="col-md-4">
                    <span class="font-weight-bold">Produk</span> <br>
                    @foreach($getProductOrder as $gpo)
                        @if($gpo->customer_code == $lpr->customer_code)
                            <ul>
                                <li>{{$gpo->product_name}} : {{$gpo->qty_order}} Pcs.</li>
                            </ul>
                        @endif
                    @endforeach
                    <br>
                </div>
                <div class="col-md-4">
                    <button type="button" class="btn btn-info btn-sm rounded-pill">Diterima</button>
                    <button type="button" class="btn btn-danger btn-sm rounded-pill">Pending</button>
                </div>
            </div>
        </div>
    </div>        
@endforeach