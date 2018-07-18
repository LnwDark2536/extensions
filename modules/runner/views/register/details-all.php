<?php

use yii\helpers\Url;
use yii\helpers\Html;
$this->title = @Yii::$app->request->get('id');
?>
    <div class="panel panel-primary">
        <div class="panel-heading">
            <h3 class="panel-title">จัดส่งรอบวันที่ <?php echo @Yii::$app->request->get('id') ?></h3>
        </div>
        <div class="panel-body">
            <div class="text-right">

                <?php echo \yii\helpers\Html::button('<i class="glyphicon glyphicon-ok"></i>  ยืนยันการส่ง', ['class' => 'btn btn-success  btn-del', 'id' => 'id_send']) ?>
                <a href="<?= \yii\helpers\Url::to(['register/send-print', 'id' => @Yii::$app->request->get('id')]) ?>"
                   class="btn btn-primary"><i class="glyphicon glyphicon-print"></i> Print</a>
            </div>
            <table class="table table-bordered table-hover">
                <thead>
                <tr>
                    <th width="2%">
                        <label class="checkbox-inline"><input name="CheckAll" type="checkbox" id="CheckAll" class="">All</label>
                    </th>
                    <th>#</th>
                    <th>ชื่อ-นามสกุล</th>
                    <th>ที่อยู่</th>
                    <th>เบอร์ติดต่อ</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($dataProvider as $key => $model): ?>
                    <tr class="<?= $model['send_status'] == 1 ?'success' :' '?>">
                        <?php if ($model['send_status'] == 1): ?>
                            <td>
                               <i class="glyphicon glyphicon-send "></i>
                            </td>
                        <?php else:?>
                            <td>
                                <input type="checkbox" name="select[]" id="check_id-<?php echo $key + 1; ?>"
                                       value="<?= $model['id'] ?>">
                            </td>
                        <?php endif; ?>
                        <td><?= $key + 1 ?></td>
                        <td><?= $model['fullname'] ?></td>
                        <td><?= $model['address'] . ' ' . @$model['soi'] . ' ' . $model['street'] . ' ' . $model['district'] . ' ' . $model['amphoe'] . ' ' . $model['province'] . ' ' . $model['zipcode'] ?></td>
                        <td><?= $model['phone'] ?></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

<?php
$sen = count($dataProvider);
$url = Url::to(['save-send']);
$js = <<<JS
const  dataClount=$sen;
$('#CheckAll').on('click', function(event){
    for(var i=1;i<=dataClount;i++){
        if(this.checked){
            $('#check_id-'+i).prop('checked', true);
        }else {
             $('#check_id-'+i).prop('checked', false);
        }
    }
});
$('#id_send').on('click',function() {
    
    var packing=[];
  for(var i=1;i<=dataClount;i++){
      if($('#check_id-'+i).prop('checked') === true){
          packing.push($('#check_id-'+i).val());
      }
    }
    if(packing.length > 0){
      var  send =confirm("ต้องการบันทึกการส่ง ใช่หรือไม่ ?")
     if(send){
        jQuery.post('$url',{id:packing},function(){});   
     }
    }else {
        alert("กรุณาเลือกรายการ...")
           console.log('no'); 
    }
     // console.log(packing)
});

$('#packing').on( "click",function() {
		$("#quick-access").css("bottom","0px");
    });

JS;
$this->registerJs($js);

?>