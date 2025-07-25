<div class="row d-block d-md-none">
    <div class="col-md-12">
        <div>
            <a href="#" class="btn btn-app bg-secondary">
                <i class="fas fa-barcode"></i>
                Product
            </a>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-9">
        <div class="card border-0 shadow">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4 col-12">
                        <div class="info-box">
                            <span class="info-box-icon bg-info elevation-1"><i class="fas fa-boxes-stacked"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">All Product</span>
                                <span class="info-box-number">
                                    {{$countItem}}
                                    <br>                                    
                                    <a href="#" class="MORE-INFO text-dark" data-path="mainProduct">
                                        <small>
                                            More Info <i class="fa-solid fa-arrow-right"></i>
                                        </small>
                                    </a>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 col-12">
                        <div class="info-box">
                            <span class="info-box-icon bg-info elevation-1"><i class="fa-solid fa-store"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">All Customer</span>
                                <span class="info-box-number">
                                    0
                                    <br>                                    
                                    <a href="#" class="MORE-INFO text-dark" data-path="tabMenuPelanggan">
                                        <small>
                                            More Info <i class="fa-solid fa-arrow-right"></i>
                                        </small>
                                    </a>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 col-12">
                        <div class="info-box">
                            <span class="info-box-icon bg-info elevation-1"><i class="fa-solid fa-user-tie"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">Sales Activity</span>
                                <span class="info-box-number">
                                    0
                                    <br>                                    
                                    <a href="#" class="text-dark" data-path="tabMenuPelanggan">
                                        <small>
                                            More Info <i class="fa-solid fa-arrow-right"></i>
                                        </small>
                                    </a>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 col-12">
                        <div class="info-box">
                            <span class="info-box-icon bg-info elevation-1"><i class="fas fa-boxes-stacked"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">Customer Deals</span>
                                <span class="info-box-number">
                                    0
                                    <br>                                    
                                    <a href="#" class="text-dark" data-path="tabMenuPelanggan">
                                        <small>
                                            More Info <i class="fa-solid fa-arrow-right"></i>
                                        </small>
                                    </a>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border border-1 border-info">
            <div class="card-body">

            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('.MORE-INFO').on('click', function (e) {
            e.preventDefault();
            let path = $(this).attr('data-path');
            $("#divContent").load(route_main+'/'+path);
        });
    });
</script>