<?= $this->extend('layout/template') ?>

<?= $this->section('content'); ?>

<div class="container">
    <table class="mt-3" style="width: 100%;">
        <tr>
            <td style="text-align: left;"><a href="/grafik-hari"><img src="img/left.png"></a></td>
            <td style="width: 80%;">
                <figure class="highcharts-figure">
                    <div id="container"></div>
                </figure>
            </td>
            <td style="text-align: right;"><a href="/grafik-bulan"><img src="img/right.png"></a></td>
        </tr>
    </table>
</div>

<script>
    Highcharts.chart('container', {
        chart: {
            type: 'column'
        },
        title: {
            text: 'Grafik Jumlah Tweet Per Jam Tahun 2020'
        },
        xAxis: {
            categories: [
                '00.00',
                '01.00',
                '02.00',
                '03.00',
                '04.00',
                '05.00',
                '06.00',
                '07.00',
                '08.00',
                '09.00',
                '10.00',
                '11.00',
                '12.00',
                '13.00',
                '14.00',
                '15.00',
                '16.00',
                '17.00',
                '18.00',
                '19.00',
                '20.00',
                '21.00',
                '22.00',
                '23.00'
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
                        echo " " . $tt['jam'] . ", ";
                    endforeach; ?>]

        }, {
            name: 'Tweet Laki-Laki',
            data: [<?php
                    foreach ($tlaki as $tl) :
                        echo " " . $tl['jam'] . ", ";
                    endforeach; ?>]

        }, {
            name: 'Tweet Perempuan',
            data: [<?php
                    foreach ($tpuan as $tp) :
                        echo " " . $tp['jam'] . ", ";
                    endforeach; ?>]

        }]
    });
</script>

<?= $this->endSection(); ?>