<div class="row">
    @foreach($productList as $pL)
    <div class="col-12 col-md-2">
        <div class="card">
          <img class="card-img-top" src="{{asset('public/images/nope-not-here.webp')}}" alt="Card image cap">
          <div class="card-body text-xs">
            <p class="card-text" title="{{$pL->product_name}}"> <b>{{substr($pL->product_name,0,15)}} ...</b></p>
            <p class="card-text"><small>{{$pL->product_satuan}}</small><br><b>Rp.{{number_format($pL->product_price_sell,'0',',','.')}}</b></p>
              <form class="form text-xs">
                  <div class="form-group">
                    <label class="label">Atur Jumlah</label>
                    <input type="number" class="form-control form-control-sm border-danger" name="jumlah">
                  </div>
                  <div class="form-group">
                        <button class="btn btn-success btn-sm btn-block"><i class="fa-solid fa-cart-shopping"></i> Beli Langsung</button>
                        <button class="btn btn-warning btn-sm btn-block"><i class="fa-solid fa-bag-shopping"></i> Keranjang</button>
                  </div>
              </form>
          </div>
        </div>
    </div>
    @endforeach
</div>