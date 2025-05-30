<div class="card card-body text-xs table-responsive p-1">
    <table class="table table-sm table-valign-middle text-nowrap table-hover" id="tableListAP">
        <thead>
            <tr>
                <th>Nomor</th>
                <th>Tgl. Penerimaan</th>
                <th>Jatuh Tempo</th>
                <th>Supplier</th>
                <th>Nominal</th>
                <th>Dibayar</th>
                <th>Saldo Hutang</th>
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
                    <td>
                        <span data-toggle="tooltip" data-placement="top" title="{{$tPayment->store_name}}">
                            {{substr($tPayment->store_name,0,10)}}
                        </span>
                    </td>
                    <td class="text-right">
                        <span class="text-danger font-weight-bold">
                            {{number_format($tPayment->kredit,'0',',','.')}}
                        </span>
                    </td>
                    <td class="text-right">
                        <span class="text-success font-weight-bold">
                            {{number_format($tPayment->payed,'0',',','.')}}
                        </span>
                    </td>
                    <td class="text-right">
                        <span class="text-info font-weight-bold">
                            {{number_format($tPayment->selisih,'0',',','.')}}
                        </span>
                    </td>
                    <td class="text-right">
                        <button type="button" class="btn btn-sm btn-success BAYAR" data-id="{{$tPayment->idp_kredit}}" title="Bayar"><i class="fa-solid fa-file-invoice-dollar"></i></button>
                        <button type="button" class="btn btn-sm btn-info BTN-OPEN-MODAL-GLOBAL-LG" href="{{route('Purchasing')}}/Bayar/modalDetailKredit/{{$tPayment->idp_kredit}}" title="Detail"><i class="fa-solid fa-magnifying-glass"></i></button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
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
    $(document).ready(function(){
        $(".dataTable").on('click','.BAYAR', function () {
            $("#displayNotif").fadeIn("slow");
            let el = $(this);
            let dataID = el.attr('data-id');
            $.ajax({
                type:'get',
                url:"{{route('Purchasing')}}/Bayar/modalMethod/" + dataID, 
                success : function(response){
                    $('#displayAP').html(response);
                    $("#displayNotif").fadeOut("slow");
                }     
            }); 
        });
    });
</script>