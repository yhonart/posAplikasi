<?php
    if ($nextID == 0) {
        $nextIdVal = '1';
    }
    else {
        $nextIdVal = $nextID + 1;
    }

    if (empty($nextIdSatuan)) {
        $nextIdUnit = '1';
    }
    else {
        $nextIdUnit = $nextIdSatuan->idm_product_satuan + 1;
    }
?>
<input type="text" name="testINput" id="testInput" class="form-control form-control-sm">