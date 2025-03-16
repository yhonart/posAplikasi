<?php
    $arrayStatus = array(
        ''=>"",
        0=>"Dihapus",
        1=>"Dlm. Proses",
        2=>"Hold",
        3=>"Kredit",
        4=>"Berhasil"
    );

    $arrayColour = array(
        ''=>"",
        0=>"text-danger",
        1=>"text-info",
        2=>"text-warning",
        3=>"text-orange",
        4=>"text-success"
    );

?>
@if($dataTrx == '0')
    <div class="card card-body">
        <span>Tidak ada jenis transaksi yang dipilih!</span>
    </div>
@else
    <div class="card card-body table-responsive">
        <table class="table table-sm table-valign-middle table-hover" id="dataTablePenjualan">
            <thead>
                <tr>
                    <th>Nomor</th>
                    <th>Pelanggan</th>
                    <th>Tanggal</th>
                    <th>Total</th>
                    <th>Status</th>
                    <th>#</th>
                </tr>
            </thead>
            <tbody>
                @foreach($dataTrx as $dtr)
                    <tr>
                        <td>{{$dtr->billing_number}}</td>
                        <td>{{$dtr->customer_name}}</td>
                        <td>{{$dtr->tr_date}}</td>
                        <td class="text-right">{{number_format($dtr->t_pay,'0',',','.')}}</td>
                        <td>
                            <span class="font-weight-bold {{$arrayColour[$dtr->status]}}">
                                {{$arrayStatus[$dtr->status]}}
                            </span>
                        </td>
                        <td class="text-right">
                            @if($dtr->status == 4)
                            <button type="button" class="btn btn-sm btn-info  BTN-EDIT" data-id="{{$dtr->tr_store_id}}"><i class="fa-solid fa-pencil"></i></button>
                            @else
                            <button type="button" class="btn btn-sm btn-warning  BTN-DETAIL"><i class="fa-solid fa-eye"></i></button>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endif

<script>
    $(function () {
        $('#dataTablePenjualan').DataTable({
          "paging": true,
          "lengthChange": true,
          "searching": true,
          "ordering": true,
          "info": true,
          "autoWidth": false,
          "responsive": true,
        });
    });
    $(document).ready(function(){
        $(".dataTable").on('click','.BTN-EDIT', function () {
            let el = $(this);
            let id = el.attr("data-id");
            $("#loadSpinner").fadeIn("slow");
            $.ajax({
                type: 'get',
                url: "{{route('trxJualBeli')}}/editPenjualan/" + id, 
                success : function(response){
                    $("#actionDisplay").html(response);
                    $("#loadSpinner").fadeOut("slow");
                }           
            });
        });
    });
</script>