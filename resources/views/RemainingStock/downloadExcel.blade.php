<?php
header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=Inventory_Control.xls");
    $besar = '0';
    $c = '0';
    $no = '1';
?>
<table border="1" cellpadding="0" cellspacing="0" style="width:100%">
    <thead style="background-color: #065f46; color:white">
        <tr>
            <th>No</th>
            <th>Kode Barang</th>
            <th>Item</th>
            <th>Satuan</th>
            <th>Jumlah</th>
            <th>Satuan-1</th>
            <th>Isi</th>
            <th>Satuan-2</th>
            <th>Isi</th>
            <th>Satuan-3</th>
        </tr>
    </thead>
    <tbody>
        @foreach($mProduct as $mp)
            <tr>
                <td>{{$no++}}</td>
                <td>{{$mp->product_code}}</td>
                <td>{{$mp->product_name}}</td>
                <td align="right">{{$mp->size_code}} {{$mp->product_satuan}}</td>
                <td align="right">
                    <?php
                        foreach($totalStock as $tStock){
                            if($tStock->idm_data_product == $mp->idm_data_product){
                                echo "<span class='font-weight-bold text-info'>".$tStock->sumstock."</span>";
                            }
                        }
                    ?>
                </td>
                <td>
                    <?php
                        foreach($mUnit as $filData){
                            if ($filData->core_id_product == $mp->idm_data_product)  {
                                if ($filData->size_code == '1') {
                                    echo $filData->product_satuan;
                                }
                            }
                        }
                    ?>
                    
                </td>
                <td align="right">
                    <?php
                        foreach($mUnit as $filDataVol){
                            if ($filDataVol->core_id_product == $mp->idm_data_product)  {
                                if ($filDataVol->size_code == '1') {
                                    echo $filDataVol->product_volume;
                                }
                            }
                        }
                    ?>
                    
                </td>
                <td>
                    <?php
                        foreach($mUnit as $filData2){
                            if ($filData2->core_id_product == $mp->idm_data_product)  {
                                if ($filData2->size_code == '2') {
                                    echo $filData2->product_satuan;
                                }
                            }
                        }
                    ?>
                    
                </td>
                <td align="right">
                    <?php
                        foreach($mUnit as $filDataVol2){
                            if ($filDataVol2->core_id_product == $mp->idm_data_product)  {
                                if ($filDataVol2->size_code == '2') {
                                    echo $filDataVol2->product_volume;
                                }
                            }
                        }
                    ?>
                    
                </td>
                <td>
                    <?php
                        foreach($mUnit as $filData){
                            if ($filData->core_id_product == $mp->idm_data_product)  {
                                if ($filData->size_code == '3') {
                                    echo $filData->product_satuan;
                                }
                            }
                        }
                    ?>
                    
                </td>
            </tr>
        @endforeach
    </tbody>
</table>