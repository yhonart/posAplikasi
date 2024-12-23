<table class="table table-sm table-align-middle text-nowrap table-hover ">
    <thead class="bg-gray-dark">
        <tr>
            <th>Nomor</th>
            <th>Tgl. Penerimaan</th>
            <th>Jatuh Tempo</th>
            <th>Supplier</th>
            <th>Nominal</th>
            <th>Bayar</th>
            <th>Keterangan</th>
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
                    <input type="text" class="form-control form-control-sm form-control-border price-tag" name="kredit" id="kredit" value="{{$tPayment->sub_total}}" readonly>
                </td>
                <td>
                    <input type="text" placeholder="Input nominal disini" class="form-control form-control-sm form-control-border price-tag" name="pay" id="pay" autocomplete="off" onchange="saveChangePembayaran(this,'purchase_kredit_payment','kredit_pay','{{$tPayment->purchase_number}}','nomor')">    
                </td>
                <td>
                    
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
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