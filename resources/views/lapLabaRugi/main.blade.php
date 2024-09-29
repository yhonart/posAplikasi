@extends('layouts.sidebarpage')
@section('content')
    <!-- Header -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-md-8 col-12">          
                        <h1 class="m-0">Laporan Laba/Rugi</h1>
                    </div>          
                </div>
            </div>
        </div>
    <!-- content -->
    <div class="content mt-0">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-12">
                    <form id="formFilterLaporan">
                        <div class="row">
                        <div class="col-md-3">
                                <div class="form-group">
                                    <label class="label">Produk Item</label>
                                    <select class="form-control form-control-sm rounded-0" name="produk" id="produk">
                                        <option value="0">All Item</option>                                        
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="label">Dari Tanggal</label>
                                    <input class="form-control form-control-sm rounded-0 datetimepicker-input" name="fromDate" id="fromDate">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="label">s/d Tanggal</label>
                                    <input class="form-control form-control-sm rounded-0 datetimepicker-input" name="endDate" id="endDate">
                                </div>
                            </div>                            
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <button type="submit" class="btn btn-sm btn-info btn-flat"><i class="fa-solid fa-filter"></i> Filter</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div id="displayFilterTable"></div>
                </div>
            </div>
        </div>
    </div>
<script>
    $(function(){
        $("#produk").select2();
        $( ".datetimepicker-input" ).datepicker({
            dateFormat: 'yy-mm-dd',
            autoclose: true,
            todayHighlight: true,
        });
        $('.datetimepicker-input').datepicker("setDate",new Date());

        $.ajax({
            url: "{{route('lapLabaRugi')}}/getDisplayAll",
            type: 'GET',
            success: function (response) {                
                $("#displayFilterTable").html(response);
            }
        });
    })

</script>
@endsection