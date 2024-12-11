<div id="container"></div>

<script>
    

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
                @foreach($penjualan as $xAxisDate)
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
            name: 'Penjualan',
            data: [
                @foreach($penjualan as $ySeriesData1)
                    {{$ySeriesData1->totalPayment}},
                @endforeach
            ]
        }, 
        {
            name: 'Pembelian',
            data: [
                @foreach($pembelian as $ySeriesData2)
                    {{$ySeriesData2->totalPayment}},
                @endforeach
            ]
        },
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