<div id="container"></div>

<script>
    Highcharts.chart('container', {
        chart: {
            type: 'column'
        },
        title: {
            text: 'Data Penjualan Per Bulan',
            align: 'left'
        },
        xAxis: {
            categories: [                
                @foreach($garpPenjualan as $xAxisDate)
                    '{{$xAxisDate->date_trx}}',
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
                    @foreach($garpPenjualan as $ySeriesData1)
                        {{$ySeriesData1->totalPayment}},
                    @endforeach
                ]
            }
        ]
    });
</script>