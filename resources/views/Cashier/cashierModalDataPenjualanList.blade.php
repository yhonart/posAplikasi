<?php
    $no = '0';
    $arayStatus = array(
        0=>"Return",
        1=>"Active",
        2=>"Hold",
        3=>"On Loan",
        4=>"Completed",
    );
?>
<div id="dataPaginate">
    <div class="row">
        <div class="col-4">
            <p class="badge badge-success p-2">Total : {{$listDataSelling->total()}}</p>
        </div>
        <div class="col-4">
            <p class="badge badge-success p-2">Total Transaksi : {{number_format($countBelanja->sumPayment,'0',',','.')}}</p>
        </div>
    </div>
    <div class="row">
        <div class="col-12 table-responsive">
            <table class="table table-sm table-striped table-hover table-valign-middle text-xs table-bordered">
                <thead>
                    <tr>
                        <th>No</th>            
                        <th>Tanggal</th>            
                        <th>Pelanggan</th>
                        <th>Jumlah</th>
                        <th>Bayar</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($listDataSelling as $lds)
                        <tr>
                            <td>{{$lds->trx_code}}</td>
                            <td>{{$lds->date_trx}}</td>
                            <td>{{$lds->customer_store}}</td>
                            <td>{{number_format($lds->total_payment)}}</td>
                            <td>{{$lds->method_name}}</td>
                        </tr>
                    @endforeach
                </tbody>
                <tfooter>
                    {{$listDataSelling->links()}}
                </tfooter>
            </table>
        </div>
    </div>
</div>
<script>
    function ajaxPaging() {
        $('.pagination a').on('click', function (e) {
            e.preventDefault();
            var url = $(this).attr('href');
            $('#dataPaginate').load(url);
        });
    }
    ajaxPaging();

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
</script>