<?php
$saldoTransaksi = 0;
$debit = 0;
$kredit = 0;
$saldoPenjualan = 0;
$saldoPembelian = 0;
$sumPembelian = 0;
$addSaldo = 0;
?>
<a href="{{route('kasKecil')}}/cetakKasKecil/0/{{$fromDate}}/{{$endDate}}" class="btn btn-success btn-sm"><i class="fa-solid fa-file-excel"></i> Download Excel</a>
<hr>
<div class="table-responsive">
    <table class="table table-sm table-hover table-valign-mmiddle text-nowrap table-bordered" id="tableKasBesar">
        <thead class="bg-gray-dark">
            <tr>
                <th>Tanggal</th>
                <th>Nomor</th>
                <th>Keterangan</th>
                <th>Debit</th>
                <th>Kredit</th>
                <th>Saldo</th>
            </tr>
        </thead>
        <tbody>
            @foreach($lapKasBesar as $lkb)
                <tr>
                    <td>{{date('d-M-Y', strtotime($lkb->trx_date))}}</td>
                    <td>{{$lkb->trx_number}}</td>
                    <td>{{$lkb->description}}</td>
                    <td>{{number_format($lkb->debit,'0',',','.')}}</td>
                    <td>{{number_format($lkb->kredit,'0',',','.')}}</td>
                    <td>
                        <?php
                            $addSaldo += $lkb->debit - $lkb->kredit;
                            echo number_format($addSaldo,'0',',','.');
                        ?>
                    </td>
                </tr>
            @endforeach            
        </tbody>
        
    </table>
</div>

<script>
    $(function(){        
        $("#tableKasBesar").DataTable({
            // "responsive": true, 
            "lengthChange": false, 
            "autoWidth": false,
            "dom": 'Bfrtip',
            "paging": false,
            "searching":true,
            "ordering":false,
            "buttons": ["copy", "csv", "excel", "pdf", "print"],
            "columnDefs": [                
                { targets: [ 3,4,5 ], className: 'dt-right' }
            ],
            // initComplete: function () {
            //     this.api()
            //     .columns()
            //     .every(function () {
            //         let column = this;
            //         let title = column.footer().textContent;
    
            //         // Create input element
            //         let input = document.createElement('input');
            //         input.placeholder = title;
            //         column.footer().replaceChildren(input);
    
            //         // Event listener for user input
            //         input.addEventListener('keyup', () => {
            //             if (column.search() !== this.value) {
            //                 column.search(input.value).draw();
            //             }
            //         });
            //     });
            // }
        }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
    });
</script>