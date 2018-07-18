<?php
$this->title="รายงานยังไม่มารับเสื้อ";
use kartik\grid\GridView;
use yii\helpers\Html;
use \kartik\export\ExportMenu;

?>
<div class="register-index">
    <?php $columns=[
        ['class' => 'yii\grid\SerialColumn'],
        [
            'attribute' => 'firstname',
            'headerOptions' => ['style' => 'width:20%'],
            'pageSummary'=>'Total',
            'pageSummaryOptions'=>['class'=>'text-right text-warning'],
//                        'group'=>true
        ],
        [
            'attribute' => 'lastname',
            'headerOptions' => ['style' => 'width:20%'],
            'pageSummary'=>'Total',
            'pageSummaryOptions'=>['class'=>'text-right text-warning'],
//                        'group'=>true
        ],
        [
            'attribute' => 'id_card',
            'format'=>'text'
        ],

        [
            'label' => 'เบอร์โทร',
            'attribute'=>'phone',
            'headerOptions' => ['class' => 'text-center','style' => 'width:10%'],
        ],
        [
            'label' => 'เบอร์โทร(ฉุกเฉิน)',
            'attribute'=>'emergency_phone',
            'headerOptions' => ['class' => 'text-center','style' => 'width:10%'],
        ],
        [
            'label' => 'ประเภทสมัคร',
            'attribute'=>'type_register',
            'headerOptions' => ['class' => 'text-center','style' => 'width:10%'],
        ],
        [
            'label' => 'ระยะ (Km)',
            'attribute'=>'type_run',
            'headerOptions' => ['class' => 'text-right'],
            'contentOptions' => ['class' => 'text-right']
        ],
        [
            'label' => 'ขนาดเสื้อ',
            'attribute'=>'size_shirts',
            'headerOptions' => ['class' => 'text-right'],
            'contentOptions' => ['class' => 'text-right']
        ],


        [
            'label' => 'การรับสินค้า',
            'attribute'=>'DeliveryName',
            'headerOptions' => ['class' => 'text-right'],
            'contentOptions' => ['class' => 'text-right']
        ],
        [
            'label' => 'รุ่นอายุ',
            'headerOptions' => ['class' => 'text-right', 'style' => 'width:10%'],
            'contentOptions' => ['class' => 'text-right'],
            'attribute'=>'genName'
        ],
        [
            'label' => 'เพศ',
            'format'=>'raw',
//            'headerOptions' => ['style' => 'width:10%'],
            'attribute'=>'sexName'
        ],

    ];
    $exportConfig=[
        [
            'attribute' => 'fullName',
            'headerOptions' => ['style' => 'width:40%'],
            'pageSummary'=>'Total',
            'pageSummaryOptions'=>['class'=>'text-right text-warning'],
        ],
        [
            'label' => 'เลขบัตรประชาชน',
            'attribute' => 'citizenName',
            'format'=>'text'
        ],
        [
            'label' => 'เบอร์โทร',
            'attribute'=>'phone',
            'headerOptions' => ['class' => 'text-center','style' => 'width:10%'],
        ],
        [
            'label' => 'ขื่อผู้ติดต่อกรณี(ฉุกเฉิน)',
            'attribute'=>'emergency_name',
            'headerOptions' => ['class' => 'text-center','style' => 'width:10%'],
        ],
        [
            'label' => 'เบอร์โทร(ฉุกเฉิน)',
            'attribute'=>'emergency_phone',
            'headerOptions' => ['class' => 'text-center','style' => 'width:10%'],
        ],
        [
            'label' => 'ประเภทสมัคร',
            'attribute'=>'type_register',
            'headerOptions' => ['class' => 'text-center','style' => 'width:10%'],
        ],
        [
            'label' => 'ระยะ (Km)',
            'attribute'=>'type_run',
            'headerOptions' => ['class' => 'text-right','style' => 'width:10%'],
            'contentOptions' => ['class' => 'text-right']
        ],
        [
            'label' => 'ขนาดเสื้อ',
            'attribute'=>'size_shirts',
            'headerOptions' => ['class' => 'text-right', 'style' => 'width:10%'],
            'contentOptions' => ['class' => 'text-right']
        ],
        [
            'label' => 'รุ่นอายุ',
            'headerOptions' => ['class' => 'text-right', 'style' => 'width:10%'],
            'contentOptions' => ['class' => 'text-right'],
            'attribute'=>'genName'
        ],
        [
            'label' => 'เพศ',
            'format'=>'raw',
            'attribute'=>'sexName'
        ],


    ]
    ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
//        'filterModel' => $searchModel,
        'columns' =>$columns,
        'exportConfig' => [
            GridView::EXCEL => [
                'label' => 'Excel',
                'icon' => 'file-excel-o',
                'iconOptions' => ['class' => 'text-success'],

                'showHeader' => true,
                'showPageSummary' => true,
                'showFooter' => true,
                'showCaption' => true,
                'filename' => 'grid-export',
                'alertMsg' => 'The EXCEL export file will be generated for download',
                'options' => ['title' => 'Microsoft Excel 95+'],
                'mime' => 'application/vnd.ms-excel',
                'config' => [
                    'worksheet' => 'ExportWorksheet',
                    'cssFile' => ''
                ]
            ],
        ],
        'containerOptions' => ['style' => 'overflow: auto'], // only set when $responsive = false
        'headerRowOptions' => ['class' => 'kartik-sheet-style'],
        'filterRowOptions' => ['class' => 'kartik-sheet-style'],
        'pjax' => true, // pjax is set to always true for this demo
        // set your toolbar
        'toolbar' =>  [
            [
                'content' =>''
            ],

            '{toggleData}',
            ExportMenu::widget([
                'dataProvider' => $dataProvider,
                'columns' => $exportConfig,
                'hiddenColumns' => [7],
                'filename'=>$this->title.time(),
                //'disabledColumns'=>[1, 2], // ID & Name
                'fontAwesome' => true,
//                'stream' => false,
                'dropdownOptions' => [
                    'label' => 'Export',
                    'class' => 'btn btn-danger'
                ],
                'exportConfig' => [
                    ExportMenu::FORMAT_TEXT => false,
                    ExportMenu::FORMAT_PDF => false,
                    ExportMenu::FORMAT_HTML => false,
                    ExportMenu::FORMAT_CSV => false,
                    ExportMenu::FORMAT_EXCEL_X => true,
                    ExportMenu::FORMAT_EXCEL => [

                        'label' => 'ออกรายงาน excel ',
                        'icon' => 'file-excel-o',
                        'iconOptions' => ['class' => 'text-success'],
                        'showHeader' => true,
                        'alertMsg' => 'ยืนยันการออกรายงาน',
                        'filename' => 'ออกรายงานผู้สมัครทั้งหมด',
                        'options' => ['title' => 'Excel'],
                        'alertMsg' => 'ยืนยันการ',

                        'mime' => 'application/application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                        'extension' => 'xls',
//                                'writer' => 'Excel2007'
                    ],
                ],
            ])
        ],
        // set export properties
        'export'=>[
            'fontAwesome'=>true,
            'showConfirmAlert'=>false,
            'target'=>GridView::TARGET_BLANK
        ],
        // parameters from the demo form
        'showPageSummary' => false,
        'striped'=>true,
        'hover'=>true,
        'bordered' => true,
        'condensed' => true,
        'responsive' => true,
        'panel' => [
            'type' => GridView::TYPE_PRIMARY,
            'heading' => Html::encode($this->title),
        ],
        'persistResize' => false,
        'toggleDataOptions' => ['minCount' => 5],
    ]); ?>

</div>