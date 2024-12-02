<?php
    $no = '1';
    $arayStatus = array(
        0=>"Batal",
        1=>"Dlm. Proses",
        2=>"Hold",
        3=>"Kredit",
        4=>"Berhasil",
    );
    $arayColor = array(
        0=>"border-danger",
        1=>"border-info",
        2=>"border-warning",
        3=>"border-primary",
        4=>"border-success",
    );
    $total = '0';
?>
<div class="row">
    <div class="col-md-12">
        <div class="card card-body teble-responsive">
            <p>Log Data Transaksi</p>
            <table class="table table-sm table-valign-middle">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Barang</th>
                        <th>Qty</th>
                        <th>Satuan</th>
                        <th>Hrg. Satuan</th>
                        <th>Disc</th>
                        <th>Jumlah</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($dbSelectTrx as $hisTrx)
                        <tr>
                            <td>{{$no++}}</td>
                            <td>{{$hisTrx->product_name}}</td>
                            <td>{{$hisTrx->qty}}</td>
                            <td>{{$hisTrx->unit}}</td>
                            <td class="text-right">
                                {{number_format($hisTrx->unit_price,'0',',','.')}}
                            </td>
                            <td class="text-right">
                                {{number_format($hisTrx->disc,'0',',','.')}}
                            </td>
                            <td class="text-right">
                                {{number_format($hisTrx->t_price,'0',',','.')}}
                                <?php
                                    $total += $hisTrx->t_price;
                                ?>
                            </td>
                            <td class="text-right">                                
                                <select name="changesStatus" id="changesStatus{{$hisTrx->list_id}}" class="form-control form-control-sm change-status">
                                    <option value="0|0">{{$arayStatus[$hisTrx->status]}} {{$hisTrx->status}}</option>
                                    <option value="4|{{$hisTrx->list_id}}">Berhasil</option>
                                    <option value="0|{{$hisTrx->list_id}}">Batalkan</option>
                                </select>
                            </td>
                        </tr>
                    @endforeach
                        <tr>
                            <td colspan="6" class="bg-light font-weight-bold">Total </td>
                            <td class="bg-light font-weight-bold">{{number_format($total,'0',',','.')}}</td>
                            <td></td>
                        </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
<script>
    $(document).ready(function(){
        $(".change-status").change(function(){
            var changeStatus = $(this).find(":selected").val(),
                trxCode = "{{$noBill}}";
            $.ajax({
                type : 'post',
                url : "{{route('Dashboard')}}/loadDataTransaksi/postChangesStatus",
                data :  {changeStatus:changeStatus, trxCode:trxCode},
                success : function(data){                
                    alertify.success('Status Berhasil Dirubah');                    
                }
            }); 
        });
    });
</script>