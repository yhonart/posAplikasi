@extends('layouts.frontpage')

@section('content')
<nav class="main-header navbar navbar-expand-md navbar-dark navbar-purple border-0 elevation-1">
    <div class="container">
        <span class="d-flex navbar-brand"><span><b>Asset</b> Management </span></span>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <i class="fas fa-ellipsis-h"></i>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="order-1 order-md-3 navbar-nav navbar-no-expand ml-auto" id="top-menu">
                <li class="nav-item">
                    <a class="nav-link" href="{{route('home')}}">
                        Home
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link ITEM-MAIN-MENU" href="#" data-menu="company" data-toggle="tab" id="tab-menu-company" data-replace="Company">
                        Dashboard
                    </a>
                </li>
    
                <li class="nav-item dropdown">
                    <a class="nav-link" data-toggle="dropdown" href="#">
                        Assets
                    </a>
                    <div class="dropdown-menu dropdown-menu-right">
                        <a href="#" class="dropdown-item ITEM-MAIN-MENU" data-menu="AllAssets">
                            All Assets
                        </a>
                        <a href="#" class="dropdown-item ITEM-MAIN-MENU" data-menu="AssetsLoan">
                            Asset Loan
                        </a>
                    </div>
                </li>

                <li class="nav-item dropdown">
                    <a class="nav-link" data-toggle="dropdown" href="#">
                        Sparepart
                    </a>
                    <div class="dropdown-menu dropdown-menu-right">                        
                        <a href="#" class="dropdown-item ITEM-MAIN-MENU" data-menu="AllSparepart">
                            All Sparepart
                        </a>
                        <a href="#" class="dropdown-item ITEM-MAIN-MENU" data-menu="HistorySparepart">
                            History Sparepart
                        </a>
                    </div>
                </li>

                <li class="nav-item dropdown">
                    <a class="nav-link" data-toggle="dropdown" href="#">
                        Master Data
                    </a>
                    <div class="dropdown-menu dropdown-menu-right">
                        <span class="dropdown-item dropdown-header">Master Data</span>
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item ITEM-MAIN-MENU" data-menu="M_Category">
                            Category
                        </a>
                        <a href="#" class="dropdown-item ITEM-MAIN-MENU" data-menu="M_Manufacture">
                            Manufacture
                        </a>
                        <a href="#" class="dropdown-item ITEM-MAIN-MENU" data-menu="M_Model">
                            Model
                        </a>
                        <a href="#" class="dropdown-item ITEM-MAIN-MENU" data-menu="M_Material">
                            Material Group
                        </a>
                        <a href="#" class="dropdown-item ITEM-MAIN-MENU" data-menu="M_Unit">
                            Unit
                        </a>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</nav>
<div class="content-wrapper">    
    <div id="DivContent"></div>    
</div>
<script>
    $(document).ready(function(){
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });        
        $('.ITEM-MAIN-MENU').on('click', function (e) {
            e.preventDefault();
            let link = $(this).attr('data-menu');
            $("#DivContent").load(link);
        });
        // Initial 
        $('#tab-menu-home').trigger('click');
    })
</script>
@endsection