<table class="table table-sm table-align-middle text-nowrap table-hover ">
    <thead class="bg-gray-dark">
        <tr>
            <th>Nomor</th>
            <th>Tgl. Penerimaan</th>
            <th>Jatuh Tempo</th>
            <th>Supplier</th>
            <th>Nominal</th>
            <th>Dibayar</th>
            <th>Bayar</th>
        </tr>
    </thead>
    <tbody>
        @foreach($supKredit as $tPayment)
            <tr>
                <td>{{$tPayment->number_dok}}</td>
                <td>{{date("d/M/Y", strtotime($tPayment->dok_date))}}</td>
                <td>
                    <?php
                        $dodate = date("d/M/Y", strtotime("+".$tPayment->tenor."day",strtotime($tPayment->dok_date)));
                    ?>
                    {{$dodate}}
                </td>
                <td>{{$tPayment->store_name}}</td>
                <td class="text-right">
                    <input type="text" class="form-control form-control-sm price-tag" name="kredit" id="kredit" value="{{$tPayment->kredit}}" readonly>
                </td>
                <td>
                    {{number_format($tPayment->payed,'0',',','.')}}
                </td>
                <td>
                    <input type="text" placeholder="Kurang bayar {{$tPayment->selisih}}" class="form-control form-control-sm price-tag" name="pay" id="pay" autocomplete="off" onchange="saveChangePembayaran(this,'purchase_kredit','last_payed','{{$tPayment->idp_kredit}}','idp_kredit')">    
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