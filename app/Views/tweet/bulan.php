<?= $this->extend('layout/template') ?>

<?= $this->section('content'); ?>

<div class="container">
    <table class="mt-3" style="width: 100%;">
        <tr>
            <td style="text-align: left;"><a href="/grafik-jam"><img src="img/left.png"></a></td>
            <td style="width: 80%;">
                <figure class="highcharts-figure">
                    <div id="container"></div>
                </figure>
            </td>
            <td style="text-align: right;"><a href="/grafik-hari"><img src="img/right.png"></a></td>
        </tr>
    </table>
</div>

<script>
    Highcharts.chart('container', {
        chart: {
            type: 'column'
        },
        title: {
            text: 'Grafik Jumlah Tweet Per Bulan Tahun 2020'
        },
        xAxis: {
            categories: [
                'Jan',
                'Feb',
                'Mar',
                'Apr',
                'May',
                'Jun',
                'Jul',
                'Aug',
                'Sep',
                'Oct',
                'Nov',
                'Dec'
            ],
            crosshair: true
        },
        yAxis: {
            min: 0,
            title: {
                text: 'Jumlah Tweet'
            }
        },
        tooltip: {
            headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
            pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                '<td style="padding:0"><b>{point.y:.f} </b></td></tr>',
            footerFormat: '</table>',
            shared: true,
            useHTML: true
        },
        plotOptions: {
            column: {
                pointPadding: 0.2,
                borderWidth: 0
            }
        },
        series: [{
            name: 'Total Tweet',
            data: [<?php
                    foreach ($ttotal as $tt) :
                        echo " " . $tt['bulan'] . ", ";
                    endforeach; ?>]

        }, {
            name: 'Tweet Laki-Laki',
            data: [<?php
                    foreach ($tlaki as $tl) :
                        echo " " . $tl['bulan'] . ", ";
                    endforeach; ?>]

        }, {
            name: 'Tweet Perempuan',
            data: [<?php
                    foreach ($tpuan as $tp) :
                        echo " " . $tp['bulan'] . ", ";
                    endforeach; ?>]

        }]
    });
</script>

<?= $this->endSection(); ?>