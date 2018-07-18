<?php

use dosamigos\chartjs\ChartJs;
use kartik\grid\GridView;
$dataArray = Yii::$app->db->createCommand("
SELECT
	to_char( created_at, 'DD-mm-YYYY' ) AS date_send,
	COUNT ( ID ) 
FROM
	register 
WHERE
	register_id IS NULL 
GROUP BY
	date_send ,DATE_TRUNC('month',created_at)
ORDER BY
DATE_TRUNC('month',created_at) asc ,date_send asc
")->queryAll();
?>
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">สถิติการรับสมัคร</h3>
            </div>
            <div class="panel-body">
                <canvas id="barRegister" width="400" height="400"></canvas>
            </div>
        </div>
    </div>

</div>
<div class="row">
    <div class="col-md-4">
        <div class="panel panel-success">
            <div class="panel-heading">
                <h3 class="panel-title">รายชื่อสมัครรายวัน</h3>
            </div>
            <div class="panel-body">
                <?= GridView::widget([
                    'dataProvider' => $provider,
                    'columns' => [
                        ['class' => 'yii\grid\SerialColumn'],
                        [
                            'label' => 'ชื่อ - นามสกุล',
                            'attribute' => 'full_name',
                            'contentOptions' => ['style' => 'font-size:16px']
                        ],
                        [
                            'label' => 'วันที่สมัคร',
                            'attribute' => 'created',

                            'contentOptions' => ['style' => 'width:84px; font-size:16px;']
                        ]
//        ['class' => 'yii\grid\ActionColumn',
//        'contentOptions' => ['style' => 'width:84px; font-size:18px;']],
                    ],
                ]); ?>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="panel panel-info">
            <div class="panel-heading">
                <h3 class="panel-title">สรุปการสั่งเสื้อ</h3>
            </div>
            <div class="panel-body">
                <?= GridView::widget([
                    'dataProvider' => $provider_shirts,
                    'showPageSummary'=>true,
                    'columns' => [
                        ['class' => 'kartik\grid\SerialColumn'],
                        [
                            'label' => 'Size เสื้อ',
                            'attribute' => 'size_shirts',
                            'pageSummary' => 'Total',
                            'contentOptions' => ['style' => 'font-size:18px']
                        ],
                        [
                            'label' => 'จำนวน',
                            'attribute' => 'sum_size',
                            'contentOptions' => ['style' => 'width:84px; font-size:18px;'],
                            'pageSummary' => true
                        ]


                    ],
                ]); ?>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="panel panel-warning">
            <div class="panel-heading">
                <h3 class="panel-title">สรุปการสมัครวิ่ง</h3>
            </div>
            <div class="panel-body">
                <?= GridView::widget([
                    'dataProvider' => $provider_run,
                    'showPageSummary'=>true,
                    'columns' => [
                        ['class' => 'kartik\grid\SerialColumn'],
                        [
                            'label' => 'รายการวิ่ง',
                            'attribute' => 'type_register',
                            'pageSummary' => 'Total',
                            'contentOptions' => ['style' => 'font-size:18px']
                        ],
                        [
                            'label' => 'จำนวน',
                            'attribute' => 'sum_type_register',
                            'pageSummary' => true,
                            'contentOptions' => ['style' => 'width:84px; font-size:18px;']
                        ]
                    ],
                ]); ?>
            </div>
        </div>
    </div>

</div>
<?php
$dataJson = json_encode($dataArray);
$js = <<<JS
const  dataJson =$dataJson;
if (dataJson) {
            var data = [];
            var dataLabel = [];
            for(var item in dataJson) {
                console.log();
                data.push(dataJson[item].count);
                dataLabel.push(dataJson[item].date_send)
            }
            
 new Chart(document.getElementById("barRegister"),{
                "type":"bar",
                "data":{
                    "labels":dataLabel,
                    "datasets":[{
                        "label":"จำนวนผู้สมัคร",
                        "data":data,
                        "fill":false,
                        backgroundColor: [
                'rgba(255, 99, 132, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(255, 206, 86, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                'rgba(153, 102, 255, 0.2)',
                'rgba(255, 159, 64, 0.2)'
            ],
                       borderColor: [
                'rgba(255,99,132,1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255, 1)',
                'rgba(255, 159, 64, 1)'
            ],
                        "borderWidth":1
                    }]
                },
                "options":{
                    "scales":{
                        "yAxes":[
                            {"ticks":{"beginAtZero":true}}
                        ]
                    },
                    title: {
                        display: true,
                        position: "top",
                        text: "สถิติการสมัคร",
                        fontSize: 16,
                        fontColor: "#111"
                    },
                    maintainAspectRatio: false,
                }
            });           
            
}

JS;
$this->registerJS($js);

?>
