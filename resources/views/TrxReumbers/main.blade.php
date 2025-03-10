@extends('layouts.sidebarpage')
@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Pengembalian Dana</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item text-muted">Home</li>
                    <li class="breadcrumb-item text-muted">Transaksi Lain</li>
                    <li class="breadcrumb-item text-info active">Pengembalian Dana</li>
                </ol>
            </div>
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<div class="content mt-0">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-md-12">
                <button type="button" class="btn btn-primary CLIK-LAP font-weight-bold" data-display="tableReumbers"><i class="fa-solid fa-file-invoice-dollar"></i> History</button>
                <button type="button" class="btn btn-primary CLIK-LAP font-weight-bold" data-display="addReumbers"><i class="fa-solid fa-plus"></i> Tambah Dana</button>
            </div>
        </div>
        <div id="displayLap"></div>
    </div>
</div>
<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $(document).ready(function(){
        let display = "tableReumbers";
        displayOnClick(display);

        document.querySelectorAll(".CLIK-LAP").forEach(function(button) { 
            button.onclick = function() {
                document.querySelectorAll(".CLIK-LAP").forEach(function(btn) 
                { 
                    btn.classList.remove("active"); 
                }); 
                this.classList.toggle("active"); 
                let display = $(this).attr('data-display');
                displayOnClick(display);
            }; 
        });
        // $('.CLIK-LAP').on('click', function (e) {
        //     e.preventDefault();
        // });

        function displayOnClick(display){
            $("#displayNotif").fadeIn("slow");
            $.ajax({
                type : 'get',
                url : "{{route('trxReumbers')}}/"+display,
                success : function(response){
                    $('#displayLap').html(response);
                    $("#displayNotif").fadeOut("slow");
                }
            });
        }
    });
</script>
@endsection