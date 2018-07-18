<?php
$this->title = "ตรวจสอบหลักฐานการโอน";

use kartik\grid\GridView;
use yii\helpers\Html;
use \kartik\export\ExportMenu;

?>

<div class="register-index">
    <?php $columns = [
        ['class' => 'yii\grid\SerialColumn'],
        [
            'attribute' => 'firstname',
            'headerOptions' => ['style' => 'width:20%'],
            'pageSummary' => 'Total',
            'pageSummaryOptions' => ['class' => 'text-right text-warning'],
//                        'group'=>true
        ],
        [
            'attribute' => 'lastname',
            'headerOptions' => ['style' => 'width:20%'],
            'pageSummary' => 'Total',
            'pageSummaryOptions' => ['class' => 'text-right text-warning'],
//                        'group'=>true
        ],
        [
            'attribute' => 'id_card',
            'format' => 'text'
        ],
        [
            'attribute' => 'email',
            'format' => 'email'
        ],
        [
            'label' => 'การรับสินค้า',
            'attribute' => 'DeliveryName',
            'headerOptions' => ['class' => 'text-right'],
            'contentOptions' => ['class' => 'text-right']
        ],
        [
            'label' => 'ยอดชำระ',
            'attribute' => 'amount_price',
            'headerOptions' => ['class' => 'text-right', 'style' => 'width:10%'],
            'contentOptions' => ['class' => 'text-right'],
            'value' => function ($model) {
                if ($model->delivery_status == 1) {
                    $send = !empty($model->send_price) ? $model->send_price : 0;
                    return number_format($model->amount_price + $send, 0);
                } else {
                    return number_format($model->amount_price, 0);
                }
            }
        ],
        [
            'label' => 'หลักฐาน',
            'format' => 'html',
            'attribute' => 'slip',
            'headerOptions' => ['class' => 'text-center', 'style' => 'width:10%'],
            'contentOptions' => ['class' => 'text-center', 'style' => 'width:10%'],
            'value' => function ($data) {
                return '<a href="' . $data['slip'] . '">' . Html::img($data['slip'], ['width' => '60px']) . '</a>';
            }
        ],
        [
            'label' => 'จำนวนทีม',
            'value'=>function($model){
                return \ext\modules\runner\models\Register::find()->where(['register_id'=>$model->id])->count();
            }
        ],
        [
            'label' => 'วันที่สมัคร',
            'format' => 'html',
            'attribute' => 'created_at',
            'contentOptions' => ['class' => 'text-center', 'style' => 'width:15%'],
        ],

        [
            'label' => 'จัดการข้อมูล',
            'format' => 'html',
            'value' => function ($model) {


            if(!empty($model->email)){
            $btn= Html::a('<i class="glyphicon glyphicon-ok"></i>   อนุมัติ', ['default/save-check', 'id' => $model->id], ['class' => 'btn btn-success btn-xs']);
            }else{
                $btn= Html::a('<i class="glyphicon glyphicon-bed"></i>   อนุมัติแบบไม่ส่ง email', ['default/not-send', 'id' => $model->id], ['class' => 'btn btn-info btn-xs']);
            }
            return    Html::a('<i class="glyphicon glyphicon-eye-open"></i>  ตรวจสอบ', ['default/view-check', 'id' => $model->id], ['class' => 'btn btn-primary btn-xs']).' '.$btn;

                // Html::a('<i class="glyphicon glyphicon-remove"></i>   ไม่อนุมัติ', '', ['class' => 'btn btn-danger btn-xs']);
            }
        ],

    ];
    ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => $columns,
        'containerOptions' => ['style' => 'overflow: auto'], // only set when $responsive = false
        'headerRowOptions' => ['class' => 'kartik-sheet-style'],
        'filterRowOptions' => ['class' => 'kartik-sheet-style'],
        'pjax' => true, // pjax is set to always true for this demo
        // set your toolbar
        'toolbar' => [
            [
                'content' => ''
            ],

            '{toggleData}',
        ],
        // set export properties
        'export' => [
            'fontAwesome' => true,
            'showConfirmAlert' => false,
            'target' => GridView::TARGET_BLANK
        ],
        // parameters from the demo form
        'showPageSummary' => false,
        'striped' => true,
        'hover' => true,
        'bordered' => true,
        'condensed' => true,
        'responsive' => true,
        'panel' => [
            'type' => GridView::TYPE_WARNING,
            'heading' => Html::encode($this->title),
        ],
        'persistResize' => false,
        'toggleDataOptions' => ['minCount' => 5],
    ]); ?>
</div>
