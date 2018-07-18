<?php
use  ext\modules\runner\models\Register;

?>
<h3 class="text-center">รายชื่อผู้สมัคร เดิน-วิ่ง สิริรัตนาธรมินิมาราธอน ครั้งที่ 1</h3>
<table class="table table-bordered " width="100%" >
    <thead>
    <tr>
        <th width="5px">#</th>
        <th width="7%">ชื่อ - นามสกุล</th>
        <th width="5%">เพศ</th>
        <th width="5%">ประเภท</th>
        <th width="7%">ระยะ</th>
        <th width="7%">ขนาดเสื้อ</th>
        <th width="5%">รุ่นอายุ</th>
        <th width="5%">การรับ</th>
        <th width="5%">เบอร์</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($model_One as$k=> $mr):?>
    <tr>
        <td><?=$k+1?></td>
        <td><?=$mr['firstname'].' '.$mr['lastname']?></td>
        <td><?=Register::getSex($mr['sex'])?></td>
        <td><?=$mr['type_register']?></td>
        <td><?=$mr['type_run']?></td>
        <td><?=$mr['size_shirts']?></td>
        <td><?=Register::getDelivery($mr['delivery_status'])?></td>
        <td><?=Register::getGen($mr['type_register'],$mr['type_run'],$mr['age'])?></td>
        <td><?=$mr['phone']?></td>
    </tr>
<!--    --><?php //if(!empty($data_register_id=\ext\modules\runner\models\Register::find()->where(['register_id'=>$mr->id])->all())):?>
<!--    --><?php //foreach ( $data_register_id as $jm=> $rgs):?>
<!--    <tr class="warning">-->
<!--        <td>-</td>-->
<!--        <td >--><?//=$rgs->firstname.' '.$rgs->lastname?><!--</td>-->
<!--        <td>--><?//=$rgs->sexName?><!--</td>-->
<!--        <td>--><?//=$rgs->type_register?><!--</td>-->
<!--        <td>--><?//=$rgs->type_run?><!--</td>-->
<!--        <td>--><?//=$rgs->size_shirts?><!--</td>-->
<!--        <td></td>-->
<!--        <td>--><?//=$rgs->genName?><!--</td>-->
<!--        <td>--><?//=$rgs->phone?><!--</td>-->
<!--    </tr>-->
<!--       --><?php //endforeach;?>
<!--    --><?php //endif;?>
    <?php endforeach;?>
    </tbody>
</table>

