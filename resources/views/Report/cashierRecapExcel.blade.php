<?php 
    header("Content-type: application/vnd-ms-excel");
    header("Content-Disposition: attachment; filename=ReportHarian.xls");
    $no = '1';
?>
<?php
    $sumHrgSatuan = '0';
    $sumJumlah = '0';
    $iNumber = '0';    
?>
<table width="100%" border="1">
    <thead>
        <tr>
            <th>Tanggal</th>
            <th>No.Trx</th>
            <th>Kode Barang</th>
            <th>Nama Barang</th>
            <th>No. Pelanggan</th>
            <th>Nama Pelanggan</th>
            <th>Alamat</th>
            <th>Tlp.</th>
            <th>Tipe Pelanggan</th>
            <th>Satuan</th>
            <th>Qty</th>
            <th>Hrg. Satuan</th>
            <th>disc</th>
            <th>Jumlah</th>
            <th>Pembayaran 1</th>
            <th>Pembayaran 2</th>
            <th>Tempo</th>
            <th>Kasir</th>
            <th>Pengirim</th>
            <th>Transaksi</th>
            <th>Status 1</th>
            <th>Status 2</th>
            <th>Supplier</th>
            <th>Kategori</th>
        </tr>
    </thead>
    <tbody>
        @foreach($prdTrx as $ptrx)
            <tr>
                <td>{{$ptrx->tr_date}}</td>
                <td>{{$ptrx->billing_number}}</td>
                <td>{{$ptrx->product_code}}</td>
                <td>{{$ptrx->product_name}}</td>
                <td>{{$ptrx->customer_code}}</td>
                <td>{{$ptrx->customer_name}}</td>
                <td>{{$ptrx->address}}</td>
                <td>{{$ptrx->phone_number}}</td>
                <td>
                    @foreach($cosGroup as $cg)                        
                        @if($cg->idm_cos_group == $ptrx->customer_type)
                            {{$cg->group_name}}
                        @endif
                    @endforeach
                </td>
                <td>{{$ptrx->unit}}</td>
                <td>{{$ptrx->qty}}</td>
                <td>{{$ptrx->unit_price}}</td>
                <td>{{$ptrx->disc}}</td>
                <td>{{$ptrx->t_price}}</td>
                <td>
                    
                </td>
                <td></td>
                <td></td>
                <td>{{$ptrx->created_by}}</td>
                <td>{{$ptrx->tr_delivery}}</td>
                <td></td>
                <td></td>
                <td></td>
                <td>
                    @foreach($Supplier as $sup)
                        @if($sup->item_id == $ptrx->product_code)
                            {{$sup->supplier_name}}
                        @endif
                    @endforeach
                </td>
                <td></td>
            </tr>
            <?php
                $sumHrgSatuan += $ptrx->unit_price;
                $sumJumlah += $ptrx->t_price;
            ?>
        @endforeach
            <tr>
                <td colspan="11"> <b>TOTAL</b> </td>
                <td> <b>{{$sumHrgSatuan}}</b> </td>
                <td></td>
                <td> <b>{{$sumJumlah}}</b> </td>
                <td colspan="9"></td>
            </tr>
    </tbody>
</table>