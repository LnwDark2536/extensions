<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Register */

$this->title = $model->getFullName();
$this->params['breadcrumbs'][] = ['label' => 'Registers', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="register-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>
<div class="row">
    <div class="col-md-8">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">ข้อมูลสมาชิก <?=@$model->getFullName()?></h3>
            </div>
            <div class="panel-body">

            </div>
        </div>
        <?= DetailView::widget([
            'model' => $model,
            'attributes' => [
                'fullName',
                'sex',
                'birthday',
                'id_card',
                'phone',
                'email:email',
                'club',
                'status',
                'delivery_status',
                'type_group',
                'emergency_name',
                'emergency_phone',
                'slip',
                'created_at',
            ],
        ]) ?>
    </div>
    <div class="col-md-4"></div>
</div>


</div>

<?php
$age = 6;
if($age > 10){
    echo '10';
}else if ($age > 5){
    echo '5';
}

?>
