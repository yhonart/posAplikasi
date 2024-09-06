
<div class="card card-body table-responsive" style="height:700px;">
    <table class="table table-valign-middle table-hover" id="tableDisplayLap">
        <thead class="bg-indigo">
            <tr>
                <th>Tanggal</th>
                <th>Nomor Bukti</th>
                <th>Product</th>
                <th>Keterangan</th>
                <th>Masuk</th>
                <th>Keluar</th>
                <th>Saldo</th>
            </tr>
        </thead>
        <tbody>
            @foreach($dataReportInv as $dri)
                <tr>
                    <td>{{$dri->date_input}}</td>
                    <td>{{$dri->number_code}}</td>
                    <td>{{$dri->product_name}}</td>
                    <td>{{$dri->description}}</td>
                    <td>{{$dri->inv_in}}</td>
                    <td>{{$dri->inv_out}}</td>
                    <td>{{$dri->saldo}}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
<script>
    $(function(){
        $('#tableDisplayLap').DataTable({
          "paging": true,
          "lengthChange": false,
          "searching": true,
          "ordering": true,
          "info": true,
          "autoWidth": false,
          "responsive": true,
          "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
        });
        
    })
</script>