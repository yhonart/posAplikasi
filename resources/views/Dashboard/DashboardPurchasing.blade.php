<div class="row" id="cardInfoPembelian">
    <div class="col-12 col-md-3">
        <div class="card card-warning card-outline">
            <div class="card-header">
                <h3 class="card-title">Pembelian Belum Dibayar</h3>
            </div>
            <div class="card-body text-xs">
                <div class="row">
                    <div class="col-2"><i class="fa-solid fa-rupiah-sign"></i></div>
                    <div class="col-10 text-right">
                        <h6 class="text-danger font-weight-bold">
                            {{number_format($sumHutang->totalTunai,'0',',','.')}}
                        </h6>
                        <a href="#" class="text-success font-weight-bold text-center el-zoom filter-info" data-display="Bayar">Bayar <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-12 col-md-3">
        <div class="card card-danger card-outline">
            <div class="card-header">
                <h3 class="card-title">Pembelian Jatuh Tempo</h3>
            </div>
            <div class="card-body text-xs">
                <div class="row">
                    <div class="col-2"><i class="fa-solid fa-rupiah-sign"></i></div>
                    <div class="col-10 text-right">
                        <h6 class="text-danger font-weight-bold">
                            <?php
                                $jumlah = '0';
                                foreach($doDate as $dd){
                                    if($dd->jumlahHari > $dd->tempo){
                                        $jumlah += $dd->sub_total;
                                    }
                                }
                                echo number_format($jumlah,'0',',','.');
                            ?>
                        </h6>
                        <a href="#" class="text-success font-weight-bold text-center el-zoom filter-info" data-display="DueDate">Detail <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-12 col-md-3">
        <div class="card card-success card-outline">
            <div class="card-header">
                <h3 class="card-title">Pelunasan 30 Hari Terakhir</h3>
            </div>
            <div class="card-body text-xs">
                <div class="row">
                    <div class="col-2"><i class="fa-solid fa-rupiah-sign"></i></div>
                    <div class="col-10">
                        <h6 class="text-danger font-weight-bold">{{number_format($sum30Ago->totalTunai,'0',',','.')}}</h6>
                        <a href="#" class="text-success font-weight-bold text-center el-zoom filter-info" data-display="lastPayment">Detail <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-12 col-md-3">
        <div class="card card-success card-outline">
            <div class="card-header">
                <h3 class="card-title">Pembayaran Tunai/Transfer</h3>
            </div>
            <div class="card-body text-xs">
                <div class="row">
                    <div class="col-2"><i class="fa-solid fa-rupiah-sign"></i></div>
                    <div class="col-10">
                        <h6 class="text-success font-weight-bold">{{number_format($sumTunai->totalTunai,'0',',','.')}}</h6>
                        <a href="#" class="text-success font-weight-bold text-center el-zoom filter-info" data-display="Payed">Detail <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row" id="rowFilter">
    <div class="col-12">
        <div id="tableFilter"></div>
    </div>
</div>