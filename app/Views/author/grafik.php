<?= $this->extend('layout/template') ?>

<?= $this->section('content'); ?>

<div class="container">
    <div class="row mt-3">
        <div class="col">
            <figure class="highcharts-figure">
                <div id="container"></div>
            </figure>
        </div>
    </div>
</div>

<script>
    Highcharts.chart('container', {
        chart: {
            type: 'column'
        },
        title: {
            text: 'Grafik Akun Twitter Politisi Indonesia 2020'
        },
        xAxis: {
            categories: [
                '21-30',
                '31-40',
                '41-50',
                '51-60',
                '61-70',
                '71-80'
            ],
            crosshair: true
        },
        yAxis: {
            min: 0,
            title: {
                text: 'Jumlah Author'
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
            name: 'Total Author',
            data: [<?php
                    foreach ($ttotal as $tt) :
                        echo " " . $tt['usia'] . ", ";
                    endforeach; ?>]

        }, {
            name: 'Laki-Laki',
            data: [<?php
                    foreach ($tlaki as $tl) :
                        echo " " . $tl['usia'] . ", ";
                    endforeach; ?>]

        }, {
            name: 'Perempuan',
            data: [<?php
                    foreach ($tpuan as $tp) :
                        echo " " . $tp['usia'] . ", ";
                    endforeach; ?>]

        }]
    });
</script>

<?= $this->endSection(); ?>