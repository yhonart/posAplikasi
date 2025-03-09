<style>
    td.active{border:1px solid #818cf8;font-weight:bold;color:#faf5ff;background-color:#7e22ce}
</style>
<div class="row animate__animated animate__fadeIn">
    <div class="col-12 col-md-3">
        <div class="info-box bg-light">
            <div class="info-box-content">
                <span class="info-box-text text-center text-muted">Total Belanja Sebelumnya</span>
                <h5 class="info-box-number text-center text-muted mb-0">Rp.{{number_format($tBillLama->t_bill,'0',',','.')}}</h5>
            </div>
        </div>
    </div>
    <div class="col-12 col-md-3">
        <div class="info-box bg-info">
            <div class="info-box-content">
                <span class="info-box-text text-center">Total Belanja Saat Ini</span>
                <h5 class="info-box-number text-center mb-0">Rp.{{number_format($sumProdList->tPrice,'0',',','.')}}</h5>
            </div>
        </div>
    </div>
    <div class="col-12 col-md-3">
        <div class="info-box bg-info">
            <div class="info-box-content">
                <span class="info-box-text text-center">Selisih</span>
                <?php
                    $selisih = $tBillLama->t_bill - $sumProdList->tPrice;
                ?>
                <h5 class="info-box-number text-center mb-0">Rp.{{number_format($selisih,'0',',','.')}}</h5>
            </div>
        </div>
    </div>
</div>
<div class="row animate__animated animate__fadeIn">
    <div class="col-12">
        <div class="card">
            <div class="card-body p-0">
                <div class="row">
                    <div class="col-12">
                        <p class="bg-info p-2"><i class="fa-solid fa-circle-info"></i> Edit langsung di dalam table, jika sudah selesai silahkan klik tombol <b>SELESAI</b> / tekan <b>ESC</b>.</p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 table-responsive">                        
                        <table class="table table-sm table-hover" id="tableListBelanja">
                            <thead>
                                <tr>
                                    <th width="40%">Nama Barang</th>
                                    <th width="10%">Qty</th>
                                    <th>Satuan</th>
                                    <th>Harga satuan</th>
                                    <th>Discount</th>
                                    <th>Jumlah</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($dataTransaksi as $dtTrx)
                                    <tr>
                                        <td>
                                            {{$dtTrx->product_name}}
                                        </td>
                                        <td>
                                            <input type="number" class="form-control form-control-sm form-control-border border-width-2 qty" value="{{$dtTrx->qty}}" name="qtyEdit" id="qtyEdit" autofocus>                                            
                                        </td>
                                        <td>
                                            <select name="unitEdit" id="unitEdit" class="form-control form-control-sm form-control-border border-width-2">
                                                <option value="{{$dtTrx->unit}}">{{$dtTrx->unit}}</option>
                                                @foreach($unitList as $unList)
                                                    @if($dtTrx->product_code == $unList->core_id_product)
                                                        @if($dtTrx->unit <> $unList->product_satuan)
                                                            <option value="{{$unList->product_satuan}}">{{$unList->product_satuan}}</option>
                                                        @endif
                                                    @endif
                                                @endforeach
                                            </select>
                                        </td>
                                        <td>
                                            <input class="form-control form-control-sm form-control-border border-width-2 unitPrice price-text" value="{{$dtTrx->unit_price}}" name="unitPriceEdit" id="unitPriceEdit" readonly>                            
                                        </td>
                                        <td>
                                            <input class="form-control form-control-sm form-control-border border-width-2 discountPrice price-text" value="{{$dtTrx->disc}}" name="discEdit" id="discEdit">
                                        </td>
                                        <td>{{number_format($dtTrx->t_price,'0',',','.')}}</td>                                        
                                    </tr>
                                @endforeach
                            </tbody>                            
                        </table>
                    </div>
                </div>
            </div>
            <div class="card-foot p-2">
                <button class="btn btn-info">SELESAI</button>
            </div>
        </div>
    </div>
</div>
<script>
    $('.price-text').mask('000.000.000', {reverse: true});

    var activeQty = document.getElementById("editUnitPrice");
    var activeDisc = document.getElementById("editUnitPrice");

    function showEdit(editTableObj) {
        $(editTableObj).css("background","#c7d2fe");
        $(editTableObj).mask('000.000.000', {reverse: true});
    }

    activeQty.addEventListener('keydown', function(event) {  
        if (event.keyCode === 13) {
            event.preventDefault();
            saveToEditReturn()   
        }   
    });

    function saveToEditReturn() {  
        let trxCode = "{{$trxID}}",
            qty = $('#qtyEdit'),
            satuan = $('#unitEdit'),
            hrgSatuan = $('#unitPriceEdit');
        $(editTableObj).css("background","#FFF");
        $.ajax({
            url: "{{route('Cashier')}}/buttonAction/dataPenjualan/postEditItem",
            type: "POST",
            data:'tableName='+tableName+'&column='+column+'&editVal='+editTableObj.innerHTML+'&id='+id+'&colId='+colId,
            success: function(data){
                ajaxLoadDataSaved(trxCode);
            }
        });
    }

    function ajaxLoadDataSaved(trxCode){
        $(".LOAD-SPINNER ").fadeIn('slow');
        $.ajax({
            url: "{{route('Cashier')}}/buttonAction/dataReturn/sumDataInfo/"+trxCode,
            type: "GET",
            success: function(response){
                $(".LOAD-SPINNER ").fadeOut('slow');
                $("#dataSumPrice").html(response);                
            }
        });
    }
</script>