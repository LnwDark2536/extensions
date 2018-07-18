<?php
$model =\ext\modules\runner\models\Register::findOne(['id'=>$id]);
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <style>
        table, th, td {
            border: 1px solid black;
            border-collapse: collapse;
        }
        th, td {
            padding: 5px;
            text-align: left;
        }
    </style>
</head>
<body>
<h2 style="color: forestgreen;"> <span>&#10004;</span> อนุมัติการรับสมัครงาน เดิน-วิ่ง สิริรัตนาธรมินิมาราธอน ครั้งที่ 1 </h2>
<div class="table-responsive">
    <table class="table table-hover" width="100%">
        <thead>
        <tr  style="background: #7a43b6; color: #e1e1e1">
            <th width="10%">รายละเอียด</th>
            <th  width="50%"></th>
            <th  width="10%" align="center">ราคา</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <th align="left">ชื่อ-นามสกุล</th>
            <td><?=$model->getFullName()?></td>
            <td rowspan="10"style="text-align: center;font-size: 24px">
                <?php
                if($model->delivery_status ==1){
                    $send =!empty($model->send_price)?$model->send_price:0;
                    echo  number_format($model->amount_price +$send,0);
                }else{
                    echo  number_format($model->amount_price,0);
                }
                ?>
            </td>
        </tr>
        <tr>
            <th align="left"> เพศ</th>
            <td ><?=$model->getSexName()?></td>
        </tr>
        <tr>
            <th align="left"> เลขบัตรประชาชน</th>
            <td ><?=$model->id_card?></td>
        </tr>
        <tr>
            <th align="left"> Email</th>
            <td ><?=$model->email?></td>
        </tr>

        <tr>
            <th align="left"> เบอร์โทร</th>
            <td ><?=$model->phone?></td>
        </tr>
        <tr>
            <th align="left"> รูปแบบการรับเสื้อ</th>
            <td style="font-size: 24px;"><?=$model->getDeliveryName()?></td>
        </tr>
        <tr>
            <th align="left"> รุ่นอายุ</th>
            <td ><?=$model->getGenName()?></td>
        </tr>
        <tr>
            <th align="left"> รูปแบบที่สมัคร</th>
            <th><?=$model->type_register?> </th>
        </tr>
        <tr>
            <th align="left"> ระยะ</th>
            <td ><?=$model->type_run?> k</td>
        </tr>
        <tr>
            <th align="left"> ขนาดเสื้อ</th>
            <td ><?=$model->size_shirts?> </td>
        </tr>
        </tbody>
    </table>
<?php $ref=\ext\modules\runner\models\Register::findOne(['register_id'=>$model->id]);
if(!empty($ref)):?>
   <h3> ข้อมูลทีมหรือสมาชิก (<?=$model->club?> )</h3>
    <table class="table table-bordered table-hover" width="100%">
        <thead>
        <tr  style="background: #7a43b6; color: #e1e1e1">
            <th>#</th>
            <th width="40%">ชื่อ-นามสกุล</th>
            <th width="15%">รุ่นอายุ</th>
            <th width="10%">เพศ</th>
            <th width="15%" style="text-align: right"> รูปแบบที่สมัคร</th>
            <th width="10%" style="text-align: right">ระยะ</th>
            <th width="10%" style="text-align: right">ขนาดเสื้อ</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach (\ext\modules\runner\models\Register::find()->where(['register_id'=>$model->id])->all() as$k=> $model_ref):?>
        <tr>
            <td><?=$k+1?></td>
            <td><?=$model_ref->getFullName()?></td>
            <td ><?=$model_ref->getGenName()?></td>
            <td><?=$model_ref->getSexName()?></td>
            <th style="text-align: right"><?=$model_ref->type_register?> </th>
            <td style="text-align: right"><?=$model_ref->type_run?> k</td>
            <td style="text-align: right"><?=$model_ref->size_shirts?></td>
        </tr>
        <?php endforeach;?>
        </tbody>
    </table>
<?php endif;?>
</div>
<h4>
    - การรับเสื้อ สามารถมารับเสื้อในวันที่ 1 มิถุนายน 2561 เวลา 12.00 - 19.00 น. ณ โรงเรียนสิริรัตนาธร <br>
    - การส่งเสื้อทางไปรษณีย์ จะทำการจัดส่งภายใน 2 อาทิตย์ ก่อนการแข่งขัน

</h4>
<h4>หากมีข้อสงสัยกรุณาติดต่อ <a href="https://www.facebook.com/srtrunning">www.facbook.com/srtrunning</a> </h4>
</body>
</html>

