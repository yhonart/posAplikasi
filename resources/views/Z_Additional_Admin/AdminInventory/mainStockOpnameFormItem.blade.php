<?php
$opnameNumber = $getNumber->number_so;
?>
<div class="row">
    <div class="col-md-12">
        <div class="card card-purple">
            <div class="card-header">
                <h3 class="card-title">Stockopname {{$opnameNumber}}</h3>
            </div>
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
                                <select class="form-control form-control-sm" name="satuan" id="satuan">
                                    <option value="0" readonly>--</option>
                                </select>
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
<script>
    $(function(){
        $('#product').select2({
            width: 'resolve'
        });
        $("#product").focus();
        let paramId = "{{$opnameNumber}}";               
    });

    $(document).ready(function(){
        let productID = document.getElementById("product"),
            satuan = document.getElementById("satuan"),
            qty = document.getElementById("qty"),
            laststock = document.getElementById("lastStock"),
            documentNumber = "{{$opnameNumber}}";

        $("#product").change(function(){
            $(".LOAD-SPINNER").fadeIn();
            let productID = $(this).find(":selected").val();
            $.ajax({
                type : 'get',
                url : "{{route('sales')}}/displaySatuanProduct/" + productID,
                success : function(response){     
                    $(".LOAD-SPINNER").fadeOut();
                    $("#satuan").html(response).focus();
                }
            });
        })
    });
</script>