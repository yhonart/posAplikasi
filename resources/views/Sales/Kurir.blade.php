@extends('layouts.frontpage')
@section('content')
<script type="text/javascript">
    const route_main = "{{route('sales')}}";
</script>
<div class="content mt-1">
    <div class="container-fluid">
        <section class=" content-header">
            <div class="row">
                <div class="col-md-12">
                    <nav class="navbar navbar-expand-lg" style="width:100%;">
                        <span class="d-flex navbar-brand">Admin Delivery <i class="fa-solid fa-truck-fast text-info"></i></span>
        
                        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                            <i class="fas fa-ellipsis-h"></i>
                        </button>
        
                        <div class="collapse navbar-collapse" id="navbarSupportedContent">
                            <ul class="nav nav-pills ml-auto" id="main-menu-bar-helpdesk">                                
                                <li class="nav-item d-none d-md-block">
                                    <a class="nav-link ITEM-MAIN-MENU" href="#" data-path="mainKurir" data-toggle="tab" id="tabMenuDash">
                                        Schedule
                                    </a>
                                </li>
                                <li class="nav-item d-none d-md-block">
                                    <a class="nav-link ITEM-MAIN-MENU" href="#" data-path="historyDelivery" data-toggle="tab" id="tabMenuHistory">
                                        History
                                    </a>
                                </li>                                                             
                            </ul>
                        </div>
                    </nav>
                </div>
            </div>
        </section>
        <section class=" container-fluid">
            <div id="divContent"></div> 
            <div class="row">
                <div class="col-12">
                    <div class="modal MODAL-GLOBAL" id="modal-global-large" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
                            <div class="modal-content MODAL-CONTENT-GLOBAL">
                                <!-- Content will be placed here -->
                                <!-- class default MODAL-BODY-GLOBAL -->
                            </div>
                        </div>
                    </div>                   
                </div>
            </div>
        </section>
    </div>        
</div>
<script>
    $(function(){
        $("#divContent").load(route_main+'/mainKurir');
    });
    $(document).ready(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('.ITEM-MAIN-MENU').on('click', function (e) {
            e.preventDefault();
            let path = $(this).attr('data-path');

            $("#divContent").load(route_main+'/'+path);
        });
        
        const el_modal_all = $('.MODAL-GLOBAL'),
            el_modal_large = $('#modal-global-large'),
            id_modal_content = '.MODAL-CONTENT-GLOBAL';
        $(document).on('click','.BTN-OPEN-MODAL-GLOBAL-LG', function(e){
            e.preventDefault();
            el_modal_large.modal('show').find(id_modal_content).load($(this).attr('href'));
        });
        el_modal_all.on('show.bs.modal', function () {
            global_style.container_spinner($(this).find(id_modal_content));
        });
        el_modal_all.on('hidden.bs.modal', function () {
            $(this).find(id_modal_content).html('');
        });
    });
</script>
@endsection