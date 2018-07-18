<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use app\models\User;
/* @var $this yii\web\View */
/* @var $searchModel app\models\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Users';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create User', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
              ['class' => 'yii\grid\SerialColumn'],

//            'id',
            'username',
            // 'auth_key',
            // 'password_hash',
            // 'password_reset_token',
//            'email:email',

            //'created_at',

            'updated_at:dateTime',
            //'roleName',
            [
                'attribute'=>'role',
                'filter'=>User::getItemsAlias('role'),
                'value'=>function($model){
                    return $model->roleName;
                }
            ],
            //'statusName',
            [
                'attribute'=>'status',
                'filter'=>User::getItemsAlias('status'),
                'value'=>function($model){
                    return $model->statusName;
                }
            ],

            [
                'class' => 'yii\grid\ActionColumn',
                'options'=>['style'=>'width:120px;'],
                'buttonOptions'=>['class'=>'btn btn-default'],
                'template'=>'<div class="btn-group btn-group-sm text-center" role="group"> {view} {update} {delete} </div>'
            ],
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>
