<?php
$this->title='รายวัน-เดือน';
use kartik\daterange\DateRangePicker;
use kartik\form\ActiveForm;
use kartik\grid\GridView;

?>
<?php $form = ActiveForm::begin([
    'method' => 'post'
    , 'options' => [
        //'class'=>'form-inline'
    ]
]); ?>
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">รายการสรุปยอดการชำระ รายวัน-เดือน</h3>
        </div>
        <div class="panel-body">
            <div class="row">
                <div class="col-md-8">
                    <div class="input-group">
                        <?php
                        echo DateRangePicker::widget([
                            'name' => 'search-date',
                            'useWithAddon' => true,
                            'language' => 'th',             // from demo config
                            'hideInput' => false,           // from demo config
                            'presetDropdown' => true, // from demo config
                            'pluginOptions' => [
                                //'locale'=>['format'=>$config['format']], // from demo config
                                'separator' => 'separator',       // from demo config
                                'opens' => 'left'
                            ]
                        ]);
                        ?>
                        <span class="input-group-btn">
        <button class="btn btn-danger" type="submit"><i class="glyphicon glyphicon-search"></i> ค้นหา</button>

                    </div>
                </div>

            </div>

            <?php
            echo GridView::widget([
                'dataProvider' => $dataProvider,
                'showPageSummary' => true,
//         'filterModel' => $searchModel,
                'columns' => [
                    ['label' => 'วันที่', 'attribute' => 'created_at', 'pageSummary' => 'Total'],
                    [
                        'vAlign' => 'right',
                        'hAlign' => 'right',
                        'attribute' => 'price',
                        'label' => 'ราคายอดรวม',
                        'format' => ['decimal', 0],
                        'pageSummary' => true
                    ],


                ]
            ]);
            ?>
        </div>
    </div>
<?php ActiveForm::end(); ?>