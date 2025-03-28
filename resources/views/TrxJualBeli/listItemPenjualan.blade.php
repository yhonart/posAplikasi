<?php
    $no = '1';
?>
<div class="card card-body text-xs">
    <div class="row">
        <div class="col-lg-8">
            <table class="table table-sm table-valign-middle">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Barang</th>
                        <th>Qty</th>
                        <th>Satuan</th>
                        <th>Hrg. Satuan</th>
                        <th>Disc.</th>
                        <th>Jumlah</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($itemPenjualan as $ip)
                        <tr>
                            <td>{{$no++}}</td>
                            <td>{{$ip->product_name}}</td>
                            <td>
                                <input type="number" class="form-control form-control-sm " value="{{$ip->qty}}">
                            </td>
                            <td>{{$ip->unit}}</td>
                            <td>{{$ip->unit_price}}</td>
                            <td>{{$ip->disc}}</td>
                            <td>{{$ip->t_price}}</td>
                            <td>
                                <button type="button" class="btn btn-sm  btn-default"><i class="fa-solid fa-circle-xmark text-danger"></i></button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="col-lg-4">
            <div class="row mb-2">
                <div class="col-12">
                    <div id="displayTotal"></div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-body text-xs">
                        <form id="formUpdateDok">
                            <div class="form-group row">
                                <label class="col-md-4">Tgl. Trx</label>
                                <div class="col-md-8">
                                    <input type="text" class="form-control form-control-sm " value="{{$docPenjualan->tr_date}}">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-4">Pelanggan</label>
                                <div class="col-md-8">
                                    <select name="customer" id="customer" class="form-control form-control-sm select2-cus">
                                        <option value="{{$docPenjualan->member_id}}">{{$docPenjualan->customer_name}}</option>
                                    </select>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function(){
        var trxCode = "{{$docPenjualan->billing_number}}";
        totalBelanja(trxCode);
        
        function totalBelanja(trxCode){
            $.ajax({
                type : 'get',
                url : "{{route('trxJualBeli')}}/totalBelanja/"+trxCode,
                success : function(response){
                    $('#displayTotal').html(response);
                }
            });
        }
    });
</script>