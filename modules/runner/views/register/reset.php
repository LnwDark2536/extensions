<?php
use yii\helpers\Html;
?>

<?= Html::a('Reset All', ['register/del-all'], [
    'class' => 'btn btn-danger',
    'data' => [
        'confirm' => 'Are you sure you want to delete All this item?',
    ],
]) ?>
