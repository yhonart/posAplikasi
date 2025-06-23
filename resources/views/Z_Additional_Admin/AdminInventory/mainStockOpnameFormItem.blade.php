<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body p-1">
                <table class="table table-sm table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Product</th>
                            <th>Satuan</th>
                            <th>Qty</th>
                            <th>Last Stock</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>#</td>
                            <td>
                                <select name="product" id="product" class="form-control form-control-sm">
                                    <option value="0"></option>
                                    @foreach($getProduct as $gp)
                                        <option value="{{$gp->idm_data_product}}">{{$gp->product_name}}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td>
                                <input type="text" name="satuan" id="satuan" class="form-control form-control-sm">
                            </td>
                            <td>
                                <input type="number" name="qty" id="qty" class="form-control form-control-sm">
                            </td>
                            <td>
                                <input type="text" name="lastStock" id="lastStock" class="form-control form-control-sm">
                            </td>
                            <td>
                                <input type="submit" class="btn btn-xs btn-flat">
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>