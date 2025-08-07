<?php
    $besar = '0';
    $c = '0';
?>
<div id="loadPaginate">
    <div id="example1_wrapper"></div>
    <table class="table  table-striped table-valign-middle table-sm text-nowrap table-hover">
        <thead>
            <tr>
                <th>Nama Barang</th>
                <th>Sisa Stock</th>
                <th>Total Stock<br><small>Total Satuan Terkecil</small></th>
                <th>Saldo Stock<br><small>Total Satuan Terkecil</small></th>
            </tr>
        </thead>
        <tbody>
            @foreach($mProduct as $mp)
                <tr>
                    <td>
                        <a class="text-info float-left font-weight-bold BTN-OPEN-MODAL-GLOBAL-LG" href="{{route('remainingStock')}}/detailInfoStock/{{$mp->idm_data_product}}">{{$mp->product_name}}</a>
                    </td>
                    <td>
                        <!-- Sisa Stock Besar/Kecil/Konversi  -->
                        <?php
                            foreach($totalStock as $tStock){
                                if($tStock->idm_data_product == $mp->idm_data_product){
                                    $besar = $tStock->sumstock / $tStock->product_volume;
                                    foreach($mUnit as $filData){
                                        if($filData->size_code == '1'){
                                            if($tStock->size_code == '3'){
                                                $b = (int)$besar;
                                            }
                                            elseif($tStock->size_code == '1'){
                                                $b = $tStock->sumstock;
                                            }
                                            else{
                                                $b1 = $tStock->sumstock / $filData->product_volume;
                                                $b = (int)$b1;
                                            }
                                        }
                                        elseif($filData->size_code == '2'){
                                            if($tStock->size_code == '3'){
                                                $a = (int)$besar * $tStock->product_volume;
                                                $a1 = $tStock->sumstock - $a;
                                                $a2 = $a1 / $filData->product_volume;
                                                $b = (int)$a2;
                                            }
                                            elseif($tStock->size_code == '2'){
                                                foreach($valBesar as $vb){
                                                    if($vb->core_id_product == $filData->core_id_product){
                                                        $valB = $vb->product_volume;
                                                        $b1 = $tStock->sumstock/$valB;
                                                        $b2 = (int)$b1 * $valB;
                                                        $b = $tStock->sumstock - $b2;
                                                    }
                                                }
                                            }
                                            else{
                                                if($filData->size_code == $tStock->size_code){
                                                    $b = $tStock->sumstock / $filData->product_volume;
                                                }else{
                                                    $b = (int)$besar;
                                                }
                                            }
                                            // $b = (int)$besar;
                                        }
                                        elseif($filData->size_code == '3'){
                                            if($besar >='1'){
                                                foreach($valKecil as $valK){
                                                    if($valK->core_id_product == $filData->core_id_product){
                                                      if($valK->product_volume == '0'){
                                                            $a = $filData->product_volume * (int)$besar;
                                                            $a1 = $tStock->sumstock - $a; 
                                                            $b = $a1;
                                                      }
                                                      else{
                                                            $a = $filData->product_volume * (int)$besar;
                                                            $a1 = $tStock->sumstock - $a;
                                                            $a2 = $a1 / $valK->product_volume;
                                                            $a3 = $valK->product_volume * (int)$a2;
                                                            $b = $a1 - $a3;
                                                      }
                                                    }
                                                }
                                            }
                                            else{
                                                foreach($valKecil as $valK){
                                                    if($valK->core_id_product == $filData->core_id_product){
                                                        $a = $tStock->sumstock / $valK->product_volume;
                                                        $a1 = $valK->product_volume * (int)$a;
                                                        $a2 = $tStock->sumstock - $a1;
                                                        $b = $a2;
                                                    }
                                                }
                                            }
                                        }
                                        
                                        if($filData->core_id_product == $mp->idm_data_product AND $filData->product_satuan <> ""){
                                            if($filData->size_code=='1' AND $filData->stock=='0'){
                                                echo "<span class='ml-2'><b>".$b."</b><small>".$filData->product_satuan."</small></span>";
                                            }
                                            elseif($filData->product_volume<>'0'){
                                                    echo "<span class='ml-2'><b>".(int)$b."</b> <small>".$filData->product_satuan."/".$filData->product_volume."</small></span>";
                                                
                                            }
                                        }
                                    }
                                }
                            }
                        ?>
                        
                    </td>

                    <td class="text-right">
                        <?php
                            foreach($totalStock as $tStock){
                                if($tStock->idm_data_product == $mp->idm_data_product){
                                    echo "<span class='font-weight-bold text-info'>".$tStock->sumstock."</span>";
                                }
                            }
                        ?>
                    </td>
                                
                    <td class="text-right">
                        <span class="float-left"><i class="fa-solid fa-rupiah-sign"></i></span>
                        <?php
                            $konvDisplay = "0";
                            foreach($totalStock as $tStock2){
                                if($tStock2->idm_data_product == $mp->idm_data_product){
                                    $konvDisplay = $tStock2->product_price_order * $tStock2->sumstock;
                                    echo "<span class='font-weight-bold text-info'>".number_format($konvDisplay,'0',',','.')."</span>";
                                }
                            }
                        ?>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <span>{{$mProduct->links()}}</span>
    <!--<div class="row">-->
    <!--    <div class="col-12">-->
    <!--        <br>-->
    <!--        <a class="btn btn-default elevation-1 font-weight-bold" href="#" id="generateStock">Generate Stock</a>-->
    <!--        <div id="dataResponse"></div>-->
    <!--    </div>-->
    <!--</div>-->
</div>
<script>
    function ajaxPaging() {
        $('.pagination a').on('click', function (e) {
            e.preventDefault();
            var url = $(this).attr('href');
            $('#loadPaginate').load(url);
        });
    }
    ajaxPaging();
    $(function () {
        $('#tableAllStock').DataTable({
            dom: 'Bftip',
            "paging": true,
            "lengthChange": true,
            "searching": false,
            "ordering": true,
            "info": false,
            "autoWidth": false,
            "pageLength": 20,
            "responsive": false,
            buttons: [
                {
                    extend: 'excelHtml5',
                    title: 'Stock Control'
                },
                {
                    extend: 'pdfHtml5',
                    title: 'Stock Control'
                }
            ]
        });
        
    });
    
    $('#generateStock').on('click', function (e) {
        e.preventDefault();
        $.ajax({
            type : 'post',
            url : "{{route('remainingStock')}}/generateStock",
            success : function(response){
                // window.location.reload();
                $("#dataResponse").html(response);
            }
        });
    });
</script>