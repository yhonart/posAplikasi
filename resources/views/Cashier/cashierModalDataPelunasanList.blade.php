<table class="table table-sm table-striped text-xs">
    <thead>
        <tr>
            <th>No Transaksi</th>
            <th>Nama Pelanggan</th>
            <th>Jumlah Barang</th>
            <th>Subtotal</th>
            @if($infoCode == 2)
                <th>Pembayaran</th>
                <th>Pengembalian</th>
            @endif
            <th></th>
        </tr>
    </thead>
    <tbody>
        @foreach($dataPinjaman as $dP)
            <tr>
                <td>{{$dP->billing_number}}</td>
                <td>{{$dP->customer_name}}</td>
                <td>{{$dP->t_item}}</td>
                <td>
                    <input type="hidden" name="billPelunasan" id="billPelunasan" value="{{$dP->t_bill}}">
                    {{number_format($dP->t_bill)}}
                </td>
                @if($infoCode == 2)
                    <td>
                        <input type="text" class="form-control form-control-sm" name="bayarPinjaman" id="bayarPinjaman">
                    </td>
                    <td>
                        <input type="text" class="form-control form-control-sm" name="pengembalian" id="pengembalian">
                    </td>
                @else
                    <input type="hidden" class="form-control form-control-sm" name="pengembalian" id="pengembalian" value="0">
                    <input type="hidden" class="form-control form-control-sm" name="bayarPinjaman" id="bayarPinjaman" value="0">
                @endif
                <td>
                    <?php
                        $textBtn = "";
                        if ($dP->status >= '1' AND $dP->status <= '3') {
                            $textBtn = "Pinjam";
                        }
                        elseif ($dP->status == '4') {
                            $textBtn = "Pelunasan";
                        }
                    ?>
                <button type="button" id="btnSelectData" class="btn btn-primary btn-sm" data-bil = "{{$dP->billing_number}}" data-status = "{{$dP->status}}"><i class="fa-solid fa-circle-check"></i> {{$textBtn}}</button>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

<script>
    $(document).ready(function(){  
        $('#bayarPinjaman').mask('000.000.000', {reverse: true});        
        $("#bayarPinjaman").on('input', compute2);
        function compute2(){
            let billPelunasan = $("#billPelunasan").val(),
                paymentVal = $("#bayarPinjaman").val(),
                inputBayar = paymentVal.replace(/\./g, "");

                if (typeof inputBayar == "undefined" || typeof inputBayar == "0") {
                    return
                }
                $("#pengembalian").val(accounting.formatMoney(parseInt(inputBayar) - parseInt(billPelunasan),{
                    symbol: "",
                    precision: 0,
                    thousand: ".",
                }));
        }

        $('#btnSelectData').on('click', function(){
            let el = $(this);
            let dataBilling = el.attr("data-bil"),
                dataStatus = el.attr("data-status"),
                dataPayment = $("#bayarPinjaman").val(),
                dataPengembalian = $("#pengembalian").val();
            $.ajax({
                type : "post",
                url: "{{route('Cashier')}}/buttonAction/dataPelunasan/actionData",
                data: {noBilling:dataBilling, status:dataStatus, tPayment:dataPayment, tPengembalian:dataPengembalian},
                success: function(response) {
                    $('#scanBarcodeProduk').val("").focus();
                    $('body').removeClass('modal-open');
                    $(".MODAL-CASHIER").modal('hide'); 
                    $('.modal-backdrop').remove(); 
                }
            })
        })
    })
</script>