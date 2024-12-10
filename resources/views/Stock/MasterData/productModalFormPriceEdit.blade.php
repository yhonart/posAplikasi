<div class="card">
    <div class="card-header border-0">
        <h3 class="card-title font-weight-bold">Pengaturan Harga Utama</h3>
        <div class="card-tools">
            <button type="button" class="btn btn-tool border-0 elevation-1" data-dismiss="modal"><i class="fa-solid fa-circle-xmark"></i></button>
        </div>
    </div>
    <div class="card-body"> 
        <div class="row">
            <div class="col-12">
                <table class="table table-hover table-valign-middle  table-sm">
                    <thead>
                        <tr>
                            <th colspan="7" class="bg-info">Edit Pengaturan Pembelian </th>
                        </tr>
                    </thead>
                    <tbody id="tBodyEditUnit">
                        
                    </tbody>
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Barcode</th>
                            <th>Ukuran</th>
                            <th>Satuan</th>
                            <th>Isi</th>
                            <th>Harga Beli (Rp.)</th>
                        </tr>
                    </thead>
                    <tbody>                                
                        <tr>
                            <td></td>
                            <td>
                                <input type="text" name="setBarcodeEdit" id="setBarcodeEdit" style="text-transform: uppercase" class="form-control form-control-border">
                            </td>
                            <td>                                        
                                <select name="sizeProdEdit" id="sizeProdEdit" class="custom-select form-control-border">
                                    <option value="0" readonly></option>
                                    @foreach($listSizeNew as $lSN1)
                                        <option value="{{$lSN1->size_name}}">{{$lSN1->size_name}}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td>
                                <select name="prodUnitEdit" id="prodUnitEdit" class="custom-select form-control-border load-input">                        
                                    <option value="0"></option>
                                    @foreach($mUnit as $mU)
                                        <option value="{{$mU->unit_note}}">{{$mU->unit_note}}</option>                                                
                                    @endforeach
                                </select>
                            </td>
                            <td>
                                <input type="text" name="volProdEdit" id="volProdEdit" class="form-control form-control-border load-input">
                            </td>
                            <td>
                                <input type="text" name="priceOrderEdit" id="priceOrderEdit" style="text-transform: uppercase" class="form-control form-control-border price-text load-input">
                            </td>                                                                        
                            <td>
                                <button type="button" id="addUnitEdit" class="btn btn-block btn-info add-child-unit btn-sm">Tambah</button>
                            </td>
                        </tr>
                    </tbody>          
                </table>
                <table class="table table-hover table-valign-middle  table-sm">
                    <thead>
                        <tr>
                            <th colspan="5" class="bg-info">Edit Pengaturan Penjualan </th>
                        </tr>
                    </thead>
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Ukuran</th>
                            <th>Kategori</th>
                            <th>Harga Jual</th>
                        </tr>
                    </thead>
                    <tbody id="displayEditGroup">

                    </tbody>
                    <tbody>
                        <tr>
                            <td></td>
                            <td>
                                <select name="sizeGroupEdit" id="sizeGroupEdit" class="custom-select form-control-border">
                                    <option value="0"></option>
                                    @foreach($listSizeNew as $lSN2)
                                        <option value="{{$lSN2->size_name}}">{{$lSN2->size_name}}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td>
                                <select name="prdGroupEdit" id="prdGroupEdit" class="custom-select form-control-border">
                                    <option value="0"></option>
                                    @foreach($dataCosGroup as $cG)
                                        <option value="{{$cG->idm_cos_group}}">{{$cG->group_name}}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td>
                            <input type="text" name="priceSellEdit" id="priceSellEdit" style="text-transform: uppercase" class="form-control form-control-border price-text load-input">
                            </td>
                            <td class="text-right">                                        
                                <button type="button" id="addGroupByEdit" class="btn btn-info add-group btn-sm">Tambah</button>
                            </td>
                        </tr>
                    </tbody>
                     
                </table>
            </div>
        </div>  
    </div>
</div>
<script>
    $(document).ready(function () {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        let coreProdId = "{{$idProduct}}";
        dataTableSizeEdit(coreProdId);
        dataTableGroup(coreProdId);

        $('#addGroupByEdit').on('click', function(){ 
            let sizeGroupEdit = $("#sizeGroupEdit").find(":selected").val(),                
                prdGroupEdit = $('#prdGroupEdit').find(":selected").val(),
                prdSellGroupEdit = $("#priceSellEdit").val();            
                $.ajax({
                    type : 'post',
                    url : "{{route('Stock')}}/AddProduct/PostProductSetGrouping",
                    data :  {idProduct:coreProdId, size:sizeGroupEdit, prodCategory:prdGroupEdit, priceSell:prdSellGroupEdit},
                    success : function(data){        
                        dataTableGroup(coreProdId);
                        $("#sizeGroupEdit").value();
                        $('#prdGroupEdit').value();
                        $("#priceSellEdit").value();
                    }
                });
            $('.load-input').val(''); 
        });

        function dataTableSizeEdit(coreProdId){        
            $.ajax({
                type : 'get',
                url : "{{route('Stock')}}/AddProduct/sizeProductInput/"+coreProdId,
                success : function(response){
                    $("#tBodyEditUnit").html(response);
                }
            });
        }
        function dataTableGroup(coreProdId){               
            $.ajax({
                type : 'get',
                url : "{{route('Stock')}}/AddProduct/prodCategoryInput/"+coreProdId,
                success : function(response){
                    $("#displayEditGroup").html(response);
                }
            });
        }
    });
</script>