<?php
    $no = '0';
    $arayStatus = array(
        0=>"Return",
        1=>"Active",
        2=>"On Save",
        3=>"On Hold",
        4=>"On Loan",
        5=>"Complated",
    );
?>
<div id="dataPaginate">
    <div class="row">
        <div class="col-6">
            <h5>Total : {{$listDataSelling->total()}}</h5>
        </div>
        <div class="col-6 text-right">
            {{$listDataSelling->links()}}
        </div>
    </div>
    <table class="table table-sm table-striped table-hover table-valign-middle">
        <thead>
            <tr>
                <th>No Struk</th>            
                <th>Pelanggan</th>
                <th>Jumlah Barang</th>
                <th>Total Belanja</th>
                <th>Status</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @foreach($listDataSelling as $lds)
                <tr>
                    <td>{{$lds->billing_number}}</td>
                    <td>{{$lds->customer_name}}</td>
                    <td>{{$lds->t_item}}</td>
                    <td>{{number_format($lds->t_bill)}}</td>
                    <td>{{$arayStatus[$lds->status]}}</td>
                    <td>
                        @if($lds->status <= 4 AND $lds->status >= 1)
                        <button type="button" id="btnSelectData" class="btn btn-info btn-sm" data-bil = "{{$lds->billing_number}}"><i class="fa-solid fa-circle-check"></i></button>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
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