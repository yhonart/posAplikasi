<div class="row">
    <div class="col-12">
        <div id="listDataBarang"></div>
    </div>
</div>
<script>
    $(function(){
        let poNumber = "{{$editPurchase->purchase_number}}";
        $.ajax({
            type : 'get',
            url : "{{route('Purchasing')}}/tableInputBarang/formInput/"+poNumber,
            success : function(response){
                $("#listDataBarang").html(response);
            }
        });
    })
    function loadEditDoc(dataEdit){
        $.ajax({
            type : 'get',
            url : "{{route('Purchasing')}}/tablePenerimaan/editTable/"+dataEdit,
            success : function(response){
                $(".LOAD-SPINNER").fadeOut();
                $("#divPageProduct").html(response);
            }
        });
    }
</script>