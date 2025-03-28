<div class="card">
    <div class="card-header border-0">
        <h3 class="card-title font-weight-bold">Tambah Lokasi Baru</h3>
        <div class="card-tools">
            <button type="button" class="btn btn-tool border-0 elevation-1" data-dismiss="modal"><i class="fa-solid fa-xmark"></i></button>
        </div>
    </div>
    <div class="card-body text-xs">
        <form id="FormAddSite" autocomplete="off">
            <div class="form-group row">
                <label for="" class="col-md-4">Kode Lokasi</label>
                <div class="col-md-4">
                    <input type="text" name="locationCode" id="locationCode" class="form-control">
                </div>
            </div>
            <div class="form-group row">
                <label for="" class="col-md-4">Kota</label>
                <div class="col-md-4">
                    <input type="text" name="cityName" id="cityName" class="form-control">
                </div>
            </div>
            <div class="form-group row">
                <label for="" class="col-md-4">Nama Lokasi</label>
                <div class="col-md-4">
                    <input type="text" name="locationName" id="locationName" class="form-control">
                </div>
            </div>
            <div class="form-group row">
                <label for="" class="col-md-4">Alamat</label>
                <div class="col-md-4">
                    <input type="text" name="locationAddress" id="locationAddress" class="form-control">
                </div>
            </div>
            <div class="form-group">
                <button type="submit" id="btnSiteSave" class="btn btn-success font-weight-bold">Save</button>
            </div>
        </form>
        <div class="row">
            <div class="col-12 red-alert p-2 rounded rounded-2 mb-2 notive-display" style="display:none;">
                <span class="font-weight-bold" id="notiveDisplay" ></span>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function () {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        let loadSpinner = $(".LOAD-SPINNER"),
            routeIndex = "{{route('CompanySetup')}}",
            tableData = "warehouseTable",
            displayData = $("#displayWHTable"),
            alertNotive = $('.notive-display'); 

        $("form#FormAddSite").submit(function(event){
            event.preventDefault();
            $.ajax({
                url : "{{route('CompanySetup')}}/siteSetup/AddWarehouse/postDataWarehouse",
                type : 'POST',
                data : new FormData(this),
                async : true,
                cache : true,
                contentType : false,
                processData : false,
                success : function (data) {
                    $(".notive-display").fadeIn();
                    $("#notiveDisplay").html(data.success);
                    alertNotive.removeClass('red-alert').addClass('green-alert');
                    global_style.load_table(loadSpinner,routeIndex,tableData,displayData);
                    $("form#FormAddSite")[0].reset();
                }
            })
        })
    });
</script>