<div id="container"></div>

<script>
    

    Highcharts.chart('container', {
        title: {
            text: 'Pembelian VS Penjualan',
            align: 'left'
        },

        subtitle: {
            text: 'For {{$year}}',
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
                    for ($i=8; $i <= 12 ; $i++) { 
                        echo "'".$i."',";
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
                    for ($i=8; $i <= 12; $i++) { 
                        foreach ($penjualan as $ySeriesData1) {
                            if ($i == $ySeriesData1->displayPeriode) {
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
                    for ($i=8; $i <= 12 ; $i++) { 
                        foreach ($pembelian as $ySeriesData2) {
                            if ($i == $ySeriesData2->displayPeriode) {
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