<div id="container"></div>

<script>
    
Highcharts.chart('container', {
    chart: {
        type: 'column'
    },
    title: {
        text: 'Penjualan VS Pembelian'
    },
    subtitle: {
        text: ''            
    },
    xAxis: {
        categories: [
            <?php
                foreach ($xAxistSet as $x) {
                    echo "'".$x->periode."',";
                }
            ?>
        ],
        crosshair: true,
        accessibility: {
            description: 'Countries'
        }
    },
    yAxis: {
        min: 0,
        title: {
            text: 'Jumlah Pembayaran'
        },
        plotLines: [{
            color: '#FF0000',
            width: 2,
            value: 0,
            label: {
                text: 'Zero',
                align: 'left',
                // y: 20, /*moves label down*/
                style: {
                    color: '#fff',
                    font: '11px '
                }
            }
        }],   
        labels: {
            formatter: function () {
                return this.value;
            },
        }
    },
    plotOptions: {
        column: {
            pointPadding: 0.2,
            borderWidth: 0
        }
    },
    series: [
        {
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
        }
    ],
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