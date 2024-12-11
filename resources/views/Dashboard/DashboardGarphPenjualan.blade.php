<div id="container"></div>

<script>
    Highcharts.chart('textcontrol', {
        chart: {
            type: 'column'
        },
        title: {
            text: 'Data Penjualan Per Bulan',
            align: 'left'
        },
        xAxis: {
            categories: [   
                @foreach($penjualanVSPembelian as $xAxisDate)
                    '{{$xAxisDate->displayPeriode}}',
                @endforeach
            ],
            crosshair: true,
            accessibility: {
                description: 'Countries'
            }
        },
        yAxis: {
            min: 0,
            title: {
                text: 'Total Pendapatan'
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
                name: 'Total',
                data: [
                    @foreach($penjualanVSPembelian as $ySeriesData1)
                        {{$ySeriesData1->totalPayment}},
                    @endforeach
                ]
            }
        ]
    });

    Highcharts.chart('container', {
        title: {
            text: 'U.S Solar Employment Growth',
            align: 'left'
        },

        subtitle: {
            text: 'By Job Category. Source: <a href="https://irecusa.org/programs/solar-jobs-census/" target="_blank">IREC</a>.',
            align: 'left'
        },

        yAxis: {
            title: {
                text: 'Number of Employees'
            }
        },

        xAxis: {
            categories: [   
                @foreach($penjualanVSPembelian as $xAxisDate)
                    '{{$xAxisDate->displayPeriode}}',
                @endforeach
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
            name: 'Pembelian',
            data: [
                @foreach($penjualanVSPembelian as $ySeriesData1)
                    {{$ySeriesData1->totalPayment}},
                @endforeach
            ]
        }, {
            name: 'Manufacturing',
            data: [
                24916, 37941, 29742, 29851, 32490, 30282,
                38121, 36885, 33726, 34243, 31050, 33099, 33473
            ]
        }, {
            name: 'Sales & Distribution',
            data: [
                11744, 30000, 16005, 19771, 20185, 24377,
                32147, 30912, 29243, 29213, 25663, 28978, 30618
            ]
        }, {
            name: 'Operations & Maintenance',
            data: [
                null, null, null, null, null, null, null,
                null, 11164, 11218, 10077, 12530, 16585
            ]
        }, {
            name: 'Other',
            data: [
                21908, 5548, 8105, 11248, 8989, 11816, 18274,
                17300, 13053, 11906, 10073, 11471, 11648
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