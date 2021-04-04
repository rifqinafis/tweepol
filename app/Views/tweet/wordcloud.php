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
    var text = 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean bibendum erat ac justo sollicitudin, quis lacinia ligula fringilla. Pellentesque hendrerit, nisi vitae posuere condimentum, lectus urna accumsan libero, rutrum commodo mi lacus pretium erat. Phasellus pretium ultrices mi sed semper. Praesent ut tristique magna. Donec nisl tellus, sagittis ut tempus sit amet, consectetur eget erat. Sed ornare gravida lacinia. Curabitur iaculis metus purus, eget pretium est laoreet ut. Quisque tristique augue ac eros malesuada, vitae facilisis mauris sollicitudin. Mauris ac molestie nulla, vitae facilisis quam. Curabitur placerat ornare sem, in mattis purus posuere eget. Praesent non condimentum odio. Nunc aliquet, odio nec auctor congue, sapien justo dictum massa, nec fermentum massa sapien non tellus. Praesent luctus eros et nunc pretium hendrerit. In consequat et eros nec interdum. Ut neque dui, maximus id elit ac, consequat pretium tellus. Nullam vel accumsan lorem.';
    var lines = text.split(/[,\. ]+/g),
        data = [
            <?php
            foreach ($wordcloud as $wc) :
                echo $data1 = "{
                name: '" . $wc['words'] . "', 
                weight: " . $wc['freq'] . "
                },";
            endforeach; ?>

        ]
    console.log(data);
    Highcharts.chart('container', {
        accessibility: {
            screenReaderSection: {
                beforeChartFormat: '<h5>{chartTitle}</h5>' +
                    '<div>{chartSubtitle}</div>' +
                    '<div>{chartLongdesc}</div>' +
                    '<div>{viewTableButton}</div>'
            }
        },
        series: [{
            type: 'wordcloud',
            data: data,
            name: 'freq'
        }],
        title: {
            text: 'WORDCLOUD'
        }
    });
</script>

<?= $this->endSection(); ?>