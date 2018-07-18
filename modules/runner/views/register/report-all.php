<?php
use yii\helpers\Url;
?>
<style>
    body{
        background: #e1e1e1;
    }
</style>

<h2>รายงาน</h2>
<div class="row">
    <div class="col-md-3">
        <div class="panel panel-primary">
            <div class="panel-body">
                <a href="   <?= Url::to(['/runner/default/receive'])?>"> <h4><i class="glyphicon glyphicon-file"></i> รายงานการรับเสื้อเอง</h4></a>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="panel panel-primary">
            <div class="panel-body">
                <a href="   <?= Url::to(['/runner/default/post'])?>"> <h4><i class="glyphicon glyphicon-file"></i> รายงานการส่งไปรษณีย์</h4></a>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="panel panel-primary">
            <div class="panel-body">
                <a href="   <?= Url::to(['/runner/default/not-receive'])?>"> <h4><i class="glyphicon glyphicon-file"></i> ยังไม่ได้รับเสื้อ</h4></a>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="panel panel-primary">
            <div class="panel-body">
                <a href="   <?= Url::to(['/runner/default/ok-receive'])?>"> <h4> <i class="glyphicon glyphicon-file"></i> รับเสื้อแล้ว</h4></a>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="panel panel-primary">
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-6">
                        <h4>รายงานแบบเดี่ยว</h4>
                        <li><a href=" <?= Url::to(['/runner/default/report-excel-one'])?>">ออกรายงาน (Excel)</a></li>
                        <li><a href="<?=Url::to(['/runner/default/report-pdf-one'])?>">ออกรายงาน (Pdf)</a></li>
                    </div>
                    <div class="col-md-6">
                        <h4>รายงานแบบทีม</h4>
                        <li><a href=" <?= Url::to(['/runner/default/report-excel-team'])?>">ออกรายงาน (Excel)</a></li>
                        <li><a href="<?= Url::to(['/runner/default/report-pdf-team'])?>">ออกรายงาน (Pdf)</a></li>
                    </div>
                </div>

            </div>
        </div>
    </div>

</div>
