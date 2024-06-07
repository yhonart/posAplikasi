<div class="row">
    <div class="col-12 col-md-3">
        <div class="info-box bg-light">
            <div class="info-box-content">
                <span class="info-box-text text-center text-muted">Total Belanja Sebelumnya</span>
                <h5 class="info-box-number text-center text-muted mb-0">Rp.{{number_format($tBillLama->t_bill,'0',',','.')}}</h5>
            </div>
        </div>
    </div>
    <div class="col-12 col-md-3">
        <div class="info-box bg-info">
            <div class="info-box-content">
                <span class="info-box-text text-center">Total Belanja Saat Ini</span>
                <h5 class="info-box-number text-center mb-0">Rp.{{number_format($sumProdList->tPrice,'0',',','.')}}</h5>
            </div>
        </div>
    </div>
    <div class="col-12 col-md-3">
        <div class="info-box bg-info">
            <div class="info-box-content">
                <span class="info-box-text text-center">Selisih</span>
                <h5 class="info-box-number text-center mb-0">Rp.</h5>
            </div>
        </div>
    </div>
</div>