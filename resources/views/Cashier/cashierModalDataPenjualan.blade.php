<?php
    $dateNow = date('Y-m-d');
?>
@if($area <> '3')
<div class="row p-1">
    <div class="card card-purple">
        <div class="card-header border-0">
            <h3 class="card-title font-weight-bold">Data Penjualan</h3>
            <div class="card-tools">
                <button type="button" class="btn btn-tool border-0 elevation-1" data-dismiss="modal"><i class="fa-solid fa-xmark"></i></button>
            </div>
        </div>
        <div class="card-body text-xs text-center">
            <p class="font-weight-bold text-danger">Ooppss..! user area anda bukan di "KASIR"</p>
        </div>
    </div>
</div>
@else
<div class="row p-1">
    <div class="col-12">
        <div class="card card-purple">
            <div class="card-header border-0">
                <h3 class="card-title font-weight-bold">Data Penjualan</h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool border-0 elevation-1" data-dismiss="modal"><i class="fa-solid fa-xmark"></i></button>
                </div>
            </div>
            <div class="card-body text-xs">
                <div class="row">
                    <div class="col-8">
                        <div id="divDataPenjualan"></div>
                    </div>
                    <div class="col-4">
                        <p class="font-weight-bold">Cari</p>
                        <div class="form-group row">
                            <div class="col-5">
                                <input type="text" class="form-control form-control-border form-control-sm datetimepicker-input" id="fromDatePenjualan" name="fromDatePenjualan"/>
                            </div>
                            <div class="col-2 text-center align-items-center font-weight-bold">s/d</div>
                            <div class="col-5">
                                <input type="text" class="form-control form-control-border form-control-sm datetimepicker-input" id="endDatePenjualan" name="endDatePenjualan"/>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-12">
                                <input type="text" name="keyword" id="keyword" class="form-control form-control-border form-control-sm" placeholder="Cari No. Transaksi">
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-12">
                                <select class="form-control form-control-border form-control-sm" name="customer" id="customer">
                                    <option value="0">Nama Pelanggan</option>
                                    @foreach($pelanggan as $p)
                                        <option value="{{$p->idm_customer}}">{{$p->customer_store}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-12">
                                <select class="form-control form-control-border form-control-sm" name="jeniBayar" id="jenisBayar">
                                    <option value="0">Pilih Metode Pembayaran</option>
                                    @foreach($method as $m)
                                        <option value="{{$m->idm_payment_method}}">{{$m->method_name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <button class="btn btn-success m-1  elevation-1" id="btnLapor"><i class="fa-solid fa-shop-lock"></i> Closing Transaksi</button>
                                <button class="btn btn-danger m-1 elevation-1 " id="btnLap1"><i class="fa-solid fa-file-pdf"></i> Laporan Kasir</button>
                                <button class="btn btn-danger m-1 elevation-1 " id="btnLap2"><i class="fa-solid fa-file-pdf"></i> Ringkasan Laporan Kasir</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $( function() {
        $( ".datetimepicker-input" ).datepicker({
            dateFormat: 'yy-mm-dd',
            autoclose: true,
            todayHighlight: true,
        });
        $('#customer').select2({
            theme: 'bootstrap4',
            dropdownParent: $('#modal-global-large')
        });
        $("#customer").val(null).focus();
        $('.datetimepicker-input').datepicker("setDate",new Date());
    } );

    $(document).ready(function(){
        let fromdate = $('#fromDatePenjualan').val(),
            enddate = $('#endDatePenjualan').val(),
            customers = '0',
            keyword = '0',
            method = '0',
            timer_cari_equipment = null;
            
        funcDataPenjualan(fromdate, enddate, keyword, method, customers);
        
        $("#fromDatePenjualan").change(function(){
            let fromdate = $('#fromDatePenjualan').val(),
                enddate = $('#endDatePenjualan').val(),
                keyword = $('#keyword').val(),
                customers = $('#customer').val(),
                method = $('#jenisBayar').find(":selected").val();
                if(keyword == ''){
                    keyword = '0';
                }
                if (customers == null) {
                    customers = '0';
                }
                // alert (customers);                
            funcDataPenjualan(fromdate, enddate, keyword, method, customers);
        });
        $("#endDatePenjualan").change(function(){
            let fromdate = $('#fromDatePenjualan').val(),
                enddate = $('#endDatePenjualan').val(),
                keyword = $('#keyword').val(),
                customers = $('#customer').val(),
                method = $('#jenisBayar').find(":selected").val();
                if(keyword == ''){
                    keyword = '0';
                }
                if (customers == null) {
                    customers = '0';
                }
                
            funcDataPenjualan(fromdate, enddate, keyword, method, customers);
        });
        $("#keyword").keyup(function (e) {
            e.preventDefault();
            clearTimeout(timer_cari_equipment); 
            timer_cari_equipment = setTimeout(function(){
                let fromdate = $('#fromDatePenjualan').val(),
                    enddate = $('#endDatePenjualan').val(),
                    keyword = $("#keyword").val().trim(),
                    customers = $('#customer').val(),
                    method = $('#jenisBayar').find(":selected").val();
                if(keyword == ''){
                    keyword = '0';
                }
                if (customers == null) {
                    customers = '0';
                }
                
            funcDataPenjualan(fromdate, enddate, keyword, method, customers)}, 700)
        });
        $("#jenisBayar").change(function(){
            let fromdate = $('#fromDatePenjualan').val(),
                enddate = $('#endDatePenjualan').val(),
                keyword = $('#keyword').val(),
                customers = $('#customer').val(),
                method = $(this).find(":selected").val();
                if(keyword == ''){
                    keyword = '0';
                }
                if (customers == null) {
                    customers = '0';
                }
            funcDataPenjualan(fromdate, enddate, keyword, method, customers);
        });
        $("#customer").change(function(){
            let fromdate = $('#fromDatePenjualan').val(),
                enddate = $('#endDatePenjualan').val(),
                keyword = $('#keyword').val(),
                customers = $(this).find(":selected").val(),
                method = $(this).find(":selected").val();
                if(keyword == ''){
                    keyword = '0';
                }
            funcDataPenjualan(fromdate, enddate, keyword, method, customers);
        });
        $("#btnLapor").click(function(){
            let routeIndex = "{{route('Cashier')}}",
                urlProductList = "productList",
                panelProductList = $("#mainListProduct"),
                urlButtonForm = "buttonAction",
                panelButtonForm = $("#mainButton"),
                fromdate = $('#fromDatePenjualan').val(),
                enddate = $('#endDatePenjualan').val();
            $.ajax({
                type : "post",
                data : {fromdate:fromdate, enddate:enddate},
                url: "{{route('Cashier')}}/buttonAction/dataPenjualan/postDataClosing",
                success: function(response) {                    
                    cashier_style.load_productList(routeIndex,urlProductList,panelProductList);
                    cashier_style.load_buttonForm(routeIndex,urlButtonForm,panelButtonForm);
                    $('#prodNameHidden').val("").focus();
                    $('body').removeClass('modal-open');
                    $(".MODAL-CASHIER").modal('hide'); 
                    $('.modal-backdrop').remove(); 
                    window.open("{{route('Cashier')}}/buttonAction/trxReportClosing/"+fromdate+"/"+enddate, "_blank");
                }
            })
        }); 
        $("#btnLap1").click(function(){
            let fromdate = $('#fromDatePenjualan').val(),
                enddate = $('#endDatePenjualan').val();
            window.open("{{route('Cashier')}}/buttonAction/trxReportDetailPdf/"+fromdate+"/"+enddate, "_blank");
        })
        $("#btnLap2").click(function(){
            let fromdate = $('#fromDatePenjualan').val(),
                enddate = $('#endDatePenjualan').val(),
                customer = $("#customer").val();
                if (customer == null) {
                    customer = '0';
                }
                //alert (customer);
            window.open("{{route('Cashier')}}/buttonAction/trxReportRecapPdf/"+fromdate+"/"+enddate+"/"+customer, "_blank");
        })
    });
    function funcDataPenjualan(fromdate, enddate, keyword, method, customers){        
        $.ajax({
            type : 'get',
            url : "{{route('Cashier')}}/buttonAction/dataPenjualan/funcData/"+fromdate+"/"+enddate+"/"+keyword+"/"+method+"/"+customers,
            success : function(response){
                $("#divDataPenjualan").html(response);
            }
        });
    }
    
</script>
@endif