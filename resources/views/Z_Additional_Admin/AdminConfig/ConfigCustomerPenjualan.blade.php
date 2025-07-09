<div class="row">
    <div class="col-md-12">
        <div class="card card-purple">
            <div class="card-header">
                <h3 class="card-title">Pengaturan Penjualan Pelanggan</h3>
            </div>
            <div class="card-body">
                <div class="row mb-2">
                    <div class="col-md-12">
                        <button type="button" class="btn btn-sm btn-success font-weight-bold" id="addOrder"><i class="fa-solid fa-plus"></i> Tambah Order</button>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <table class="table table-sm table-valign-middle hover">
                            <thead>
                                <tr>
                                    <th>Kode Produk</th>
                                    <th>Nama Produk</th>
                                    <th>Qty.Order</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($customerOrder as $cor)
                                    <tr>
                                        <td>{{$cor->product_code}}</td>
                                        <td>{{$cor->product_name}}</td>
                                        <td>
                                            <input type="number" name="qtyOrderEdit" id="qtyOrderEdit" class="form-control form-control-sm" value="{{$cor->qty_order}}" onchange="saveToDatabase(this,'config_customer_order','qty_order','{{$cor->cus_order_id}}','cus_order_id')">
                                        </td>
                                        <td class="text-right">
                                            <button type="button" class="btn btn-sm btn-danger"><i class="fa-solid fa-xmark"></i></button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>  
                <div class="row">
                    <div class="col-md-12">
                        <button class="btn btn-sm btn-warning font-weight-bold" data-dismiss="modal" aria-label="Close"><i class="fa-solid fa-xmark"></i> Tutup</button>
                    </div>
                </div>              
            </div>
        </div>
    </div>
</div>

<script>
    function saveToDatabase(editableObj,tablename,column,id,idChange) {        
        $.ajax({
            url: "{{route('sales')}}/configCustomer/aturPenjualan/updateQty",
            type: "POST",
            data:'tablename='+tablename+'&column='+column+'&editval='+editableObj.value+'&id='+id+'&idChange='+idChange,            
            success: function(data){
                alertify.success('Data Berhasil Terupdate');                
            }
        });
    }
</script>