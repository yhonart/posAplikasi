<div id="container"></div>

<script>
    

    Highcharts.chart('container', {
        title: {
            text: 'Pembelian VS Penjualan',
            align: 'left'
        },

        subtitle: {
            text: 'Report ditampilkan perbulan',
            align: 'left'
        },

        yAxis: {
            title: {
                text: 'Jumlah Pembayaran'
            }
        },

        xAxis: {
            categories: [  
                <?php
                    foreach ($xAxistSet as $x) {
                        echo "'".$x."',";
                    }
                ?>
            ],
            crosshair: true,
            accessibility: {
                description: 'Countries'
            }
        },

        legend: {
            layout: 'vertical',
            align: 'right',
            verticalAlign: 'middle'
        },

        plotOptions: {
            column: {
                pointPadding: 0.2,
                borderWidth: 0
            }
        },

        series: [{
            name: 'Penjualan',
            data: [
                <?php
                    foreach ($xAxistSet as $x1) {
                        foreach ($penjualan as $ySeriesData1) {
                            if ($x1->periode == $ySeriesData1->displayPeriode) {
                                echo $ySeriesData1->totalPayment.",";
                            }
                        }                     
                    }
                ?>
            ]
        }, 
        {
            name: 'Pembelian',
            data: [
                <?php
                    foreach ($xAxistSet as $x2) {                                             
                        foreach ($pembelian as $ySeriesData2) {
                            if ($x2->periode == $ySeriesData2->displayPeriode) {
                                echo $ySeriesData2->totalPayment.",";
                            }
                        }
                    }
                ?>
            ]
        }],

        responsive: {
            rules: [{
                condition: {
                    maxWidth: 500
                },
                chartOptions: {
                    legend: {
                        layout: 'horizontal',
                        align: 'center',
                        verticalAlign: 'bottom'
                    }
                }
            }]
        }
    });
</script>