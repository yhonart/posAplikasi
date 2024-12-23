@extends('layouts.sidebarpage')
@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Pembayaran Hutang <small>(Payble/AP)</small></h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item text-muted">Home</li>
                        <li class="breadcrumb-item text-muted">Keuangan</li>
                        <li class="breadcrumb-item text-info active">Payble/AP</li>
                    </ol>
                </div>
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <div class="content mt-0">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-md-12">
                    <button type="button" class="btn btn-info CLICK-AP font-weight-bold" data-display="inputPembayaran"><i class="fa-solid fa-file-invoice-dollar"></i> Pembayaran</button>
                    <button type="button" class="btn btn-info CLICK-AP font-weight-bold" data-display="historyPembayaran"><i class="fa-solid fa-folder-open"></i> History</button>
                    <button type="button" class="btn btn-info CLICK-AP font-weight-bold" data-display="dashboardPembayaran"><i class="fa-solid fa-chart-line"></i> Dashboard AP</button>
                </div>
            </div>
            <div class="row mb-2">
                <div class="col-md-12">
                    <div id="displayAP"></div>
                </div>
            </div>
        </div>
    </div>

    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $(document).ready(function(){
            let display = "inputPembayaran";
            displayOnClick(display);

            $('.CLICK-AP').on('click', function (e) {
                e.preventDefault();
                let display = $(this).attr('data-display');
                displayOnClick(display);
            });

            function displayOnClick(display){
                $("#displayNotif").fadeIn("slow");
                $.ajax({
                    type : 'get',
                    url : "{{route('Purchasing')}}/"+display,
                    success : function(response){
                        $('#displayAP').html(response);
                        $("#displayNotif").fadeOut("slow");
                    }
                });
            }
        });
    </script>
@endsection