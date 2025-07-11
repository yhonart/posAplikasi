<?php
    $nomor = 1;
?>
@foreach($listPengiriman as $lpr)
    <div class="card border border-1 border-info shadow-sm">
        <div class="card-header">
            <h3 class="card-title font-weight-bold"><i class="fa-solid fa-store"></i> {{$lpr->customer_store}}</h3>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-12">
                    <span class="font-weight-bold">Alamat :</span> <br>
                    <small>{{$lpr->address}}</small>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <span class="font-weight-bold">Produk</span> <br>
                    @foreach($getProductOrder as $gpo)
                        @if($gpo->customer_code == $lpr->customer_code)
                            <ul>
                                <li>{{$gpo->product_name}} : {{$gpo->qty_order}} Pcs.</li>
                            </ul>
                        @endif
                    @endforeach
                    <br>
                    <button type="button" class="btn btn-info btn-sm rounded-pill elevation-2 font-weight-bold BTN-OPEN-MODAL-GLOBAL-LG" href="{{route('sales')}}/mainKurir/penerimaan/{{$lpr->delconfig_id}}/{{$lpr->customer_code}}"><i class="fa-solid fa-circle-check"></i> Diterima</button>
                    <button type="button" class="btn btn-danger btn-sm rounded-pill elevation-2 font-weight-bold BTN-OPEN-MODAL-GLOBAL-LG" href="{{route('sales')}}/mainKurir/pending/{{$lpr->delconfig_id}}"><i class="fa-solid fa-clock-rotate-left"></i> Pending</button>
                </div>
            </div>
        </div>
    </div>        
@endforeach