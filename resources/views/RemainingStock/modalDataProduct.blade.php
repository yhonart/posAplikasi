<div class="card card-body text-xs table-responsive">
    <div class="row">
        <div class="col-12">
            <table class="tabale table-sm  table-striped table-valign-middle text-nowrap" width="100%">
                <thead>
                    <tr>
                        <th>Kode Barang</th>
                        <th>Nama Barang</th>
                        <th>Kategory</th>
                        <th>Satuan</th>
                        <th>Volume</th>
                        <th>Stok <br> <small>Berdasarkan nilai terkecil</small></th>
                        <th>Stok <br> <small>Berdasarkan Unit</small></th>
                        <th>Hrg. Beli</th>
                        <th>Hrg. Jual</th>
                        <th>Saldo Stock</th>
                        <th>Lokasi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $sum = '0';
                        $konvSaldo = '0';
                    ?>
                    @foreach($viewStock as $vs)
                        <tr>
                            <td>{{$vs->product_code}}</td>
                            <td>{{$vs->product_name}}</td>
                            <td>{{$vs->product_category}}</td>
                            <td>{{$vs->product_satuan}}</td>
                            <td>{{$vs->product_volume}}</td>
                            <td class="p-0">
                                <input type="text" name="stockBarang" id="stockBarang" class="form-control form-control-sm " value="{{$vs->stock}}" onchange="saveMasterBarang(this,'inv_stock','stock','{{$vs->idinv_stock}}','idinv_stock')">
                            </td>
                            <td>{{$vs->stock_unit}}</td>
                            <td class="text-right">{{number_format($vs->product_price_order,'0',',','.')}}</td>
                            <td class="text-right">{{number_format($vs->product_price_sell,'0',',','.')}}</td>
                            <td class="text-right">
                                <?php
                                    $konvSaldo = $vs->product_price_order * $vs->stock;
                                    $sum += $konvSaldo;
                                    echo number_format($konvSaldo,'0',',','.');
                                ?>
                            </td>
                            <td>{{$vs->site_name}}</td>
                        </tr>
                    @endforeach
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td class="text-right font-weight-bold">{{number_format($sum,'0',',','.')}}</td>
                        <td></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    function saveMasterBarang(editTableObj,tableName,column,id,tableID) {
        $.ajax({
            url: "{{route('remainingStock')}}/postModalUpdateStock",
            type: "POST",
            data:'tableName='+tableName+'&column='+column+'&editVal='+editTableObj.value+'&id='+id+'&tableID='+tableID,
            success: function(data){
                Toast.fire({
                    icon: 'success',
                    title: 'Data berhasil disimpan'
                })
            }
        });
    } 
</script>