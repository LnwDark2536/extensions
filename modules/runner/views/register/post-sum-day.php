<?php
$this->title="รายการส่งสินค้า";
?>
<div class="panel panel-primary">
    <div class="panel-heading">
        <h3 class="panel-title">รายการจำนวนส่งเสื้อ SummaryByDay</h3>
    </div>
    <div class="panel-body">
        <table class="table table-bordered table-hover">
            <thead>
            <tr>
                <th>#</th>
                <th>วันที่</th>
                <th>จำนวนรายการ</th>
                <th>จัดการ</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($dataProvider  as$k=>$model):?>
            <tr>
                <td><?=$k+1;?></td>
                <td><?=$model['date_send'];?></td>
                <td><?=$model['count'];?></td>
                <td>

                    <a href="<?=\yii\helpers\Url::to(['register/details-all','id'=>$model['date_send']])?>">
                        <i class="glyphicon glyphicon-export"></i>                </a>
                </td>
            </tr>
     <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<div class="panel panel-success">
    <div class="panel-heading">
        <h3 class="panel-title"><i class="glyphicon glyphicon-send"></i> รายการจำนวนส่งเสื้อแล้ว</h3>
    </div>
    <div class="panel-body">
        <table class="table table-bordered table-hover">
            <thead>
            <tr>
                <th>#</th>
                <th>วันที่</th>
                <th>จำนวนรายการ</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach (Yii::$app->db->createCommand("SELECT DATE
	( created_at ) AS date_send,
	COUNT ( ID ) 
FROM
	register 
WHERE
	register_id IS NULL 
	AND delivery_status = 1 
	AND send_status =1
GROUP BY
	date_send 
ORDER BY
	date_send DESC")->queryAll()  as$k=>$model):?>
                <tr>
                    <td><?=$k+1;?></td>
                    <td><?=$model['date_send'];?></td>
                    <td><?=$model['count'];?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>