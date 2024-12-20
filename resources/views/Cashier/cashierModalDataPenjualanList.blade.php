<?php
    $no = '0';
    $arayStatus = array(
        0=>"Deleted",
        1=>"Active",
        2=>"Hold",
        3=>"On Loan",
        4=>"Completed",
    );
?>
<div id="dataPaginate">
    
    <div class="row">
        <div class="col-12 table-responsive">
            <table class="table table-sm table-striped table-hover table-valign-middle text-xs " id="tableTransaksi">
                <thead>
                    <tr>
                        <th>No</th>            
                        <th>Tanggal</th>            
                        <th>Pelanggan</th>
                        <th>Jumlah</th>
                        <th>Bayar</th>
                        <th>Reprint</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($listDataSelling as $lds)
                        <tr>
                            <td>{{$lds->billing_number}}</td>
                            <td>{{$lds->tr_date}}</td>
                            <td>{{$lds->customer_name}}</td>
                            <td class="text-right font-weight-bold">
                                @if($lds->trx_method == '8')
                                    {{number_format($lds->t_bill)}}
                                @else
                                    {{number_format($lds->t_bill)}}
                                @endif
                            </td>
                            @if($lds->status >= '3')
                            <td>{{$lds->method_name}}</td>
                            <td>
                                <i class="fa-solid fa-pen-to-square"></i>
                                <select class="form-control form-control-sm" name="rePrintID[]" onchange="sendReprint(this,'{{$lds->billing_number}}')">
                                    <option value="0" readonly>Pilih</option>
                                    <option value="1">Struk</option>
                                    <option value="2">Fakture</option>
                                </select>
                            </td>
                            @else
                            <td></td>
                            <td class="text-right bg-info font-weight-bold">
                                {{$arayStatus[$lds->status]}}
                            </td>
                            @endif
                            
                            
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
<script>
    $(function () {
        $('#tableTransaksi').DataTable({
          "paging": true,
          "lengthChange": false,
          "searching": false,
          "ordering": true,
          "info": true,
          "autoWidth": false,
          "responsive": true,
        });
     });
    // function ajaxPaging() {
    //     $('.pagination a').on('click', function (e) {
    //         e.preventDefault();
    //         var url = $(this).attr('href');
    //         $('#dataPaginate').load(url);
    //     });
    // }
    // ajaxPaging();

    $(document).ready(function(){
        let routeIndex = "{{route('Cashier')}}",
            urlProductList = "productList",
            panelProductList = $("#mainListProduct"),
            urlButtonForm = "buttonAction",
            panelButtonForm = $("#mainButton");

        $('#btnSelectData').on('click', function(){
            let el = $(this);
            let data = el.attr("data-bil");
            $.ajax({
                type : "get",
                url: "{{route('Cashier')}}/buttonAction/dataPenjualan/selectData/" + data,
                success: function(response) {                    
                    cashier_style.load_productList(routeIndex,urlProductList,panelProductList);
                    cashier_style.load_buttonForm(routeIndex,urlButtonForm,panelButtonForm);
                    $('#scanBarcodeProduk').val("").focus();
                    $('body').removeClass('modal-open');
                    $(".MODAL-CASHIER").modal('hide'); 
                    $('.modal-backdrop').remove(); 
                }
            })
        })
    })
    
    function sendReprint(editTableObj,trxCode){
        let editVal = editTableObj.value;
        let urlPrint = "{{route('Cashier')}}/buttonAction/printTemplateCashier/"+trxCode+"/"+editVal;
        window.open(urlPrint,'_blank');
    }
</script>