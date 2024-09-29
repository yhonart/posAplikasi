<?php
$statusDokumen = array(
    0=>"Dihapus",
    1=>"Sedang Proses",
    2=>"Review",
    3=>"Disetujui"
);
?>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body p-0">

                <table class="table table-sm table-valign-middle table-hover text-nowrap table-bordered bg-light elevation-1">
                    <thead class="bg-gradient-purple">
                        <tr>
                            <th>Tgl. Penerimaan</th>
                            <th>Nomor</th>
                            <th>Supplier</th>
                            <th>Total Belanja</th>
                            <th>Pembayaran</th>
                            <th>Status</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($listTablePem as $ltp)
                            <tr>
                                <td>{{$ltp->purchase_date}}</td>
                                <td>
                                    <span class="font-weight-bold">{{$ltp->purchase_number}}</span>
                                </td>
                                <td>
                                    <a class="font-weight-bold BTN-OPEN-MODAL-GLOBAL-LG" href="{{route('Purchasing')}}/modalSupplier/{{$ltp->supplier_id}}">
                                        {{$ltp->store_name}}
                                    </a>
                                </td>
                                <td class="text-right font-weight-bold">
                                    {{number_format($ltp->sub_total,'0',',','.')}}
                                </td>
                                <td>
                                    @if($ltp->payment_methode <> '1' AND $ltp->payment_methode <> '2')
                                    <span class="text-danger font-weight-bold">{{$ltp->tempo}} [Hari]</span>
                                    @else
                                    <span class="text-success font-weight-bold">{{$ltp->tempo}}</span>
                                    @endif
                                </td>
                                <td class="text-right">
                                    <span class="green-alert border border-success font-weight-bold pl-2 pr-2 pt-1 pb-1 rounded-pill">{{$statusDokumen[$ltp->status]}}</span>
                                </td>
                                <td class="text-right">
                                    @if($ltp->status =='2' AND $approval >= '1')
                                    <button class="btn btn-success btn-sm btn-flat font-weight-bold BTN-APPROVE" data-number="{{$ltp->purchase_number}}"><i class="fa-solid fa-check"></i> Approve</button>
                                    @endif
                                    @if($ltp->status =='2')
                                        <button class="btn btn-info btn-sm btn-flat font-weight-bold BTN-EDIT" data-number="{{$ltp->purchase_number}}"><i class="fa-solid fa-pencil"></i> Edit</button>
                                    @endif
                                    <button class="btn btn-primary font-weight-bold btn-sm btn-flat BTN-OPEN-MODAL-GLOBAL-LG" href="{{route('Purchasing')}}/modalPenerimaanPO/{{$ltp->purchase_number}}"><i class="fa-solid fa-binoculars" ></i> Detail</button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function(){
        $('.BTN-EDIT').on('click', function (e) {
            e.preventDefault();
            $(".LOAD-SPINNER").fadeIn();
            let dataEdit = $(this).attr('data-number');
            $.ajax({
                type : 'get',
                url : "{{route('Purchasing')}}/tablePenerimaan/editTable/"+dataEdit,
                success : function(response){
                    $(".LOAD-SPINNER").fadeOut();
                    $("#divPageProduct").html(response);
                }
            });
        });
        
        $('.BTN-APPROVE').on('click', function (e) {
            e.preventDefault();
            $(".LOAD-SPINNER").fadeIn();
            let dataEdit = $(this).attr('data-number');
            $.ajax({
                type : 'get',
                url : "{{route('Purchasing')}}/tablePenerimaan/btnApprove/"+dataEdit,
                success : function(response){
                    window.location.reload();
                    $(".LOAD-SPINNER").fadeOut();
                }
            });
        });
        
        $('.BTN-DETAIL').on('click', function (e) {
            e.preventDefault();
            alertify
              .alert("Oppss, Menu ini belum tersedia !.", function(){
                alertify.message('OK');
              });
        });
    });
</script>