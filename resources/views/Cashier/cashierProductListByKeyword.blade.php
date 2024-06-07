<?php
    $no='1';
?>
<ul id="ulProduct" class="list-group list-group-unbordered position-absolute elevation-1 p-2">
    @foreach($productList as $prodList)
        <li class="list-group-item LIST-PRODUCT" data-ID="{{$prodList->idm_data_product}}" data-Name="{{$prodList->product_name}}">        
            <a href="#" class="text-info">{{$prodList->product_name}}</a>            
        </li>
    @endforeach
</ul>
<script>
    $(document).ready(function(){
        $(".LIST-PRODUCT").click(function(){
            let productID = $(".LIST-PRODUCT").attr('data-ID'),
                productName = $(".LIST-PRODUCT").attr('data-Name');
            document.getElementById("prodName").value=productName;
            document.getElementById("prodNameHidden").value=productID;
            $("#ulProduct").hide();
            $("#qty").val("1").focus();
            $("#satuan").load("{{route('Cashier')}}/productList/satuan/" + productID);
        })
        
        // document.addEventListener('keydown', function(event) {  
        //     if (event.keyCode === 13) {
        //         event.preventDefault();
        //     }  
        // });
    });
</script>