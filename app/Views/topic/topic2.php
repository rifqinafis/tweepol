<?= $this->extend('layout/template') ?>
<?= $this->section('content'); ?>

<div class="container">
    <div class="row mt-3 border-bottom border-dark">
        <div class="col">
            <figure class="highcharts-figure">
                <div id="container2"></div>
            </figure>
        </div>
    </div>
    <div class="row border-top border-dark">
        <div class="col">
            <figure class="highcharts-figure">
                <div id="container3"></div>
            </figure>
        </div>
    </div>
</div>
<script>
    Highcharts.chart('container2', {
        colorAxis: {
            minColor: '#ffffff',
            maxColor: Highcharts.getOptions().colors[3]
        },
        series: [{
            type: 'treemap',
            layoutAlgorithm: 'squarified',
            data: [<?php
                    foreach ($topik as $t) :
                        echo "{
                name: '" . $t['words'] . "', 
                value: " . $t['prob'] . ",
                colorValue: " . $t['prob'] . "
                },";
                    endforeach; ?>],
            name: 'prob'

        }],
        title: {
            text: 'Topik 2: Kondisi Ekonomi saat Pandemi'
        }
    });
</script>
<script>
    Highcharts.chart('container3', {
        colorAxis: {
            minColor: '#ffffff',
            maxColor: Highcharts.getOptions().colors[3]
        },
        chart: {
            type: 'packedbubble',
            height: '100%'
        },
        title: {
            text: 'Author pada Topik 2'
        },
        tooltip: {
            useHTML: true,
            pointFormat: '<b>{point.name}</b><br>Prob: {point.value}'
        },
        plotOptions: {
            packedbubble: {
                minSize: '0%',
                maxSize: '125%',
                zMin: 0,
                zMax: 1,
                layoutAlgorithm: {
                    splitSeries: false,
                    gravitationalConstant: 0.02
                },
                dataLabels: {
                    enabled: true,
                    format: '{point.name}',
                    filter: {
                        property: 'y',
                        operator: '>',
                        value: 0.3
                    },
                    style: {
                        color: 'black',
                        textOutline: 'none',
                        fontWeight: 'normal'
                    }
                }
            }
        },
        series: [{
            name: 'Probability',
            data: [<?php
                    foreach ($atopik as $at) :
                        echo "{
                name: '" . $at['username'] . "', 
                value: " . $at['prob'] . "
                },";
                    endforeach; ?>]
        }]
    });
</script>
<?= $this->endSection(); ?>