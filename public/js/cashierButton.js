window.cashier_style = {
    load_productList:function(routeIndex,urlProductList,panelProductList){
        $.ajax({
            type:'get',
            url:routeIndex + "/" + urlProductList, 
            success : function(response){
                panelProductList.html(response);   
            }           
        });
    },

    load_buttonForm:function(routeIndex,urlButtonForm,panelButtonForm){
        $.ajax({
            type:'get',
            url:routeIndex + "/" + urlButtonForm, 
            success : function(response){
                panelButtonForm.html(response);   
            }           
        });
    }
}