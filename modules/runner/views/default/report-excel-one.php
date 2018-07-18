<?php
use \ext\modules\runner\models\Register;
?>

<html xmlns:o="urn:schemas-microsoft-com:office:office"
      xmlns:x="urn:schemas-microsoft-com:office:excel"
      xmlns="http://www.w3.org/TR/REC-html40">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

</head>
<body >
<div><h2>รายชื่อผู้สมัคร เดิน-วิ่ง สิริรัตนาธรมินิมาราธอน ครั้งที่ 1</h2></div>
<table border="1"  style="font-size: 16px;" width="100%">
    <thead>
    <tr>
        <th >#</th>
        <th>ชื่อ - นามสกุล</th>
        <th >เพศ</th>
        <th >ประเภท</th>
        <th >ระยะ</th>
        <th >ขนาดเสื้อ</th>
        <th >รุ่นอายุ</th>
        <th >การรับ</th>
        <th >เบอร์</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($data as$k=> $mr):?>
        <tr>
            <td><?=$k+1?></td>
            <td><?=$mr['firstname'].' '.$mr['lastname']?></td>
            <td><?=Register::getSex($mr['sex'])?></td>
            <td><?=$mr['type_register']?></td>
            <td><?=$mr['type_run']?></td>
            <td><?=$mr['size_shirts']?></td>
            <td><?=Register::getDelivery($mr['delivery_status'])?></td>
            <td><?=Register::getGen($mr['type_register'],$mr['type_run'],$mr['age'])?></td>
            <td><?=strval($mr['phone'])?></td>
        </tr>
    <?php endforeach;?>
    </tbody>
</table>

</body>
</html>