<div class="card card-body table-responsive p-0">
    <table class="table table-sm table-align-middle text-nowrap table-hover table-bordered">
        <thead class="bg-gray">
            <tr>
                <th>Nomor</th>
                <th>Tgl. Penerimaan</th>
                <th>Jatuh Tempo</th>
                <th>Supplier</th>
                <th>Nominal</th>
                <th>Bayar</th>
            </tr>
        </thead>
        <tbody>
            @foreach($tbPurchase as $tPayment)
                <tr>
                    <td>{{$tPayment->purchase_number}}</td>
                    <td>{{date("d/M/Y", strtotime($tPayment->delivery_date))}}</td>
                    <td>
                        <?php
                            $dodate = date("d/M/Y", strtotime("+".$tPayment->tempo."day",strtotime($tPayment->delivery_date)));
                        ?>
                        {{$dodate}}
                    </td>
                    <td>{{$tPayment->store_name}}</td>
                    <td class="text-right">
                        {{number_format($tPayment->sub_total,'0',',','.')}}
                    </td>
                    <td class="text-right">
                        @foreach($paymentKredit as $pKred)
                            @if($pKred->nomor == $tPayment->purchase_number)
                                {{number_format($pKred->kredit_pay,'0',',','.')}}
                            @endif
                        @endforeach
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
<script>
        $('.price-tag').mask('000.000.000', {reverse: true});
        var el_modal_all = $('.MODAL-GLOBAL'),
                el_modal_large = $('#modal-global-large'),
                id_modal_content = '.MODAL-CONTENT-GLOBAL';
        function saveChangePembayaran(editableObj,tablename,column,id,idKredit){
            $.ajax({
                url: "{{route('Purchasing')}}/Bayar/payPost",
                type: "POST",
                data:'tablename='+tablename+'&column='+column+'&editval='+editableObj.value+'&id='+id+'&idKredit='+idKredit,
                success: function(data){
                    el_modal_large.modal('show').find(id_modal_content).load("{{route('Purchasing')}}/Bayar/modalMethod/"+id);
                }
            });
        }
</script>