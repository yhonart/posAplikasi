<div class="form-group row">
    <label class="label col-6 col-md-2">Nama Barang</label>
    <div class="col-6 col-md-4">
        <select class="form-control form-control-sm display-select2" name="fromNamaBarang" id="fromItem">
            <option value="0">Semua Nama Barang</option>
            @foreach($filterBarang as $fB1)
                <option value="{{$fB1->product_name}}">{{$fB1->product_name}}</option>
            @endforeach
        </select>
    </div>
    <label class="label col-6 col-md-1 text-right">s/d</label>
    <div class="col-6 col-md-4">
        <select class="form-control form-control-sm display-select2" name="endNamaBarang" id="endItem">
            <option value="0">Semua Nama Barang</option>
        @foreach($filterBarang as $fB2)
            <option value="{{$fB2->product_name}}">{{$fB2->product_name}}</option>
        @endforeach
        </select>
    </div>
</div>
<script>
    $( function() {
        $(".display-select2").select2();
    } );
</script>