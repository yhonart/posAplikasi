<?php
    $arrayStatus = array(
        ''=>"",
        0=>"Deleted",
        1=>"On Process",
        2=>"Hold",
        3=>"Kredit",
        4=>"Berhasil"
    );
    $arrayBG = array(
        ''=>"bg-light",
        0=>"bg-danger",
        1=>"bg-info",
        2=>"bg-warning",
        3=>"bg-gray",
        4=>"bg-olive"
    );
?>
<!--<div class="row">-->
<!--    <div class="col-12">-->
<!--        <p class="bg-info p-2"><i class="fa-solid fa-circle-info"></i> Klik pada nomor transaksi untuk menampilkan list barang. Atau gunakan TAB pada keyboard kemudian ENTER</p>-->
<!--    </div>-->
<!--</div>-->
<div class="row d-flex justify-content-center">
    <div class="col-md-4">
        <div class="card border border-danger" id="cardConfirmPassword" style="display:none;">
            <div class="card-body">
                <form class="from" id="formKonfirmAdmin">
                    <div class="form-group row">
                        <div class="col-12">
                            <label class="text-center text-danger"><i class="fa-solid fa-triangle-exclamation"></i> Konfirmasi Admin</label>
                            <input type="hidden" class="form-control form-control-sm is-warning" name="dataId" id="datId">
                            <input type="hidden" class="form-control form-control-sm is-warning" name="dataAction" id="datAction">
                            <input type="text" class="form-control form-control-sm is-warning mb-2" name="userName" id="userName" placeholder="Username Login">
                            <input type="password" class="form-control form-control-sm is-warning mb-2" name="passInput" id="passInput" placeholder="Password Login">
                        </div>
                        <div class="col-12">
                            <button type="button" class="btn btn-flat btn-warning font-weight-bold" id="batal">Batal <i class="fa-solid fa-xmark"></i></button>
                            <button type="submit" class="btn btn-flat btn-success font-weight-bold">Lanjutkan <i class="fa-solid fa-arrow-right"></i></button>
                            <p class="text-danger" id="notifDisplay"></p>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12 table-responsive">
        <table class="table table-sm text-sm table-hover table-valign-middle text-nowrap">
            <thead class="text-center">
                <tr>
                    <th>No. Transaksi</th>
                    <th>Tanggal.</th>
                    <th>Pelanggan</th>
                    <th>Total Transaksi (Rp.)</th>
                    <th>Pembayaran</th>
                    <th>Status</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach($listDataNumber as $ldN)
                    <tr>
                        <td>
                            <a href="#" class="text-info font-weight-bold CLICK-DATA-RETURN" data-id="{{$ldN->billing_number}}" data-action="2">
                                {{$ldN->billing_number}}
                            </a>
                        </td>
                        <td>
                            <input type="text" class="form-control form-control-sm form-control-border date-change" name="editDate" value="{{$ldN->tr_date}}" onchange="saveChangeDate(this,'tr_store','tr_date','{{$ldN->tr_store_id}}','tr_store_id')">
                        </td>
                        <td>{{$ldN->customer_name}}</td>
                        <td class="text-right font-weight-bold">{{number_format($ldN->t_bill,'0',',','.')}}</td>
                        <td class="text-right">{{$ldN->method_name}}</td>
                        <td class="text-right {{$arrayBG[$ldN->status]}} font-weight-bold">{{$arrayStatus[$ldN->status]}}</td>
                        <td class="text-right">
                            <button class="btn btn-danger BTN-DELETE btn-flat" data-id="{{$ldN->billing_number}}" data-action="1">Hapus</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
<script>
    $(function(){
        $( ".date-change" ).datepicker({
            dateFormat: 'yy-mm-dd',
            autoclose: true,
            todayHighlight: true,
        });
    })
    function saveChangeDate(editableObj,tablename,column,id,dataId){
        alert(id);
        $.ajax({
            url: "{{route('Cashier')}}/buttonAction/dataReturn/changeDate",
            type: "POST",
            data:'tablename='+tablename+'&column='+column+'&editval='+editableObj.value+'&id='+id+'&dataId='+dataId,
            success: function(data){
                alertify.success('Tanggal Berhasil Dirubah');
            }
        });
    }
    $(document).ready(function(){
        let divViewId = $("#divDataReturn");        
        $(".click-info-data").click(function(){
            let element = $(this) ;
            let dataTrx = element.attr("data-id");
            let routeIndex = "{{route('Cashier')}}",
                urlProductList = "productList",
                panelProductList = $("#mainListProduct"),
                urlButtonForm = "buttonAction",
                panelButtonForm = $("#mainButton"),
                trxType = '2';
                
            $.ajax({
                type : "get",
                url: "{{route('Cashier')}}/buttonAction/dataReturn/clickListProduk/"+dataTrx+ "/"+trxType ,
                success: function(response) {                    
                    cashier_style.load_productList(routeIndex,urlProductList,panelProductList);
                    cashier_style.load_buttonForm(routeIndex,urlButtonForm,panelButtonForm);
                    $('#prodNameHidden').val("").focus();
                    $('body').removeClass('modal-open');
                    $(".MODAL-CASHIER").modal('hide'); 
                    $('.modal-backdrop').remove(); 
                }
            })
        });
        $(".BTN-DELETE").click(function(){
            let el = $(this),
                dataTrx = el.attr("data-id"),
                dataAction = el.attr("data-action");
            $("#cardConfirmPassword").show();
            $("#userName").focus();
            $("#datAction").val(dataAction);
            $("#datId").val(dataTrx);
        });
        
        $("#batal").click(function(){
            $("#cardConfirmPassword").hide();
        });
        
        $(".CLICK-DATA-RETURN").click(function(){
            let el = $(this),
                dataTrx = el.attr("data-id"),
                dataAction = el.attr("data-action");
            $("#cardConfirmPassword").show();
            $("#userName").focus();
            $("#datAction").val(dataAction);
            $("#datId").val(dataTrx);
        });
    });

    $("form#formKonfirmAdmin").submit(function(eventvendor){
        eventvendor.preventDefault();
        let dataAction = $("#datAction").val(),
            keyword = "{{$keyword}}",
            fromDate = "{{$fromDate}}",
            endDate = "{{$endDate}}";
            
        $.ajax({
            url: "{{route('Cashier')}}/buttonAction/unlockReturn",
            type: 'POST',
            data: new FormData(this),
            async: true,
            cache: true,
            contentType: false,
            processData: false,
            success: function (data) {
                if(data.warning){
                    $("#notifDisplay").html(data.warning);
                }
                else if(data.success){
                    if(dataAction === '2'){
                        window.location.reload();
                    }
                    else{
                        $("#notifDisplay").html(data.success);
                        loadDataReturn(keyword, fromDate, endDate);
                    }
                }
            }
        });
        return false;
    });
    
    function loadDataReturn(keyword, fromDate, endDate){ 
        // alert(fromDate);
        $.ajax({
            type : 'get',
            url : "{{route('Cashier')}}/buttonAction/dataReturn/searchDataReturn/"+keyword+"/"+fromDate+"/"+endDate,
            success : function(response){
                $("#divDataReturn").html(response);
            }
        });
    }
</script>