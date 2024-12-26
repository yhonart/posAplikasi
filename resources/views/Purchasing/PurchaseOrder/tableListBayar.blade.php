<table class="table table-sm table-align-middle text-nowrap table-hover" id="tableListAP">
    <thead class="bg-gray-dark">
        <tr>
            <th>Nomor</th>
            <th>Tgl. Penerimaan</th>
            <th>Jatuh Tempo</th>
            <th>Supplier</th>
            <th>Nominal</th>
            <th>Dibayar</th>
            <th>Piutang</th>
            <th></th>
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
                    {{number_format($tPayment->kredit,'0',',','.')}}
                </td>
                <td class="text-right">
                    {{number_format($tPayment->payed,'0',',','.')}}
                </td>
                <td class="text-right">
                    {{number_format($tPayment->selisih,'0',',','.')}}
                </td>
                <td class="text-right">
                    <button type="button" class="btn btn-sm btn-info BTN-OPEN-MODAL-GLOBAL-LG" href="{{route('Purchasing')}}/Bayar/modalDetail/{{$tPayment->idp_kredit}}" title="Detail"><i class="fa-solid fa-magnifying-glass"></i></button>
                    <button type="button" class="btn btn-sm btn-success BTN-OPEN-MODAL-GLOBAL-LG" href="{{route('Purchasing')}}/Bayar/modalDetailKredit/{{$tPayment->idp_kredit}}" title="Bayar"><i class="fa-solid fa-file-invoice-dollar"></i></button>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
<script>
    $(function(){
        $("#tableListAP").DataTable({
            "responsive": true, 
            "lengthChange": false, 
            "autoWidth": false,
            "dom": 'Bfrtip',
            "buttons": ["copy", "csv", "excel", "pdf", "print"]
        }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
    });
</script>