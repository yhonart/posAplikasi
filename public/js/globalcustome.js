window.global_style = {
    container_reload: function(el){
        el.html('<div class="text-center"><img src="public/img/gif/custom-load.gif" style="width: 5em;"></div>');
    },
    btn_spinner: function(el) {
        el.html('<span class="spinner-border spinner-border-sm text-light" role="status" aria-hidden="true"></span>');
    },
    container_spinner: function(el){
        el.html('<div class="text-center"><span class="spinner-border text-light" role="status" aria-hidden="true"></span></div>');
    },
    btn_spinner_wo_color: function(el) {
        el.html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>');
    },
    spinner_big: function(el) {
        el.html('<span class="spinner-border text-light" role="status" aria-hidden="true"></span>');
    },
    spinner_grower_big: function(el) {
        el.html('<span class="spinner-grow text-light" role="status" aria-hidden="true"></span>');
    },
    spinner_w_text_center: function(el) {
        el.html('<div class="text-center"><span class="spinner-border spinner-border-sm text-secondary" role="status" aria-hidden="true"></span>&nbsp;<span class="TEXT-TITLE TEXT-DESC">Loading</span></div>');
    },
    spinner_w_text_center_custom_color: function(el,color) {
        el.html('<div class="text-center '+color+'"><span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>&nbsp;<span class="TEXT-TITLE TEXT-DESC">Loading</span></div>');
    },
    hide_modal: function(){
        $('body').removeClass('modal-open');
        $(".MODAL-GLOBAL").modal('hide'); 
        $('.modal-backdrop').remove();  
    },
    load_table:function(loadSpinner,routeIndex,tableData,displayData){
        loadSpinner.fadeIn(); 
        $.ajax({
            type:'get',
            url:routeIndex + "/" + tableData, 
            success : function(response){
                loadSpinner.fadeOut(); 
                displayData.html(response);   
            }           
        });
    },
    show_swal: function(icon,msg){
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000
        });
        
        Toast.fire({
            icon: icon,
            title: msg
        })
    },
}