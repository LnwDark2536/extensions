<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Register */

$this->title = 'Update Register: ' . $model->fullName;
$this->params['breadcrumbs'][] = ['label' => 'Registers', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Update';
?>
<style>
    .modal-mask {
        position: fixed;
        z-index: 9998;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, .5);
        display: table;
        transition: opacity .3s ease;
    }

    .modal-wrapper {
        display: table-cell;
        vertical-align: middle;
    }
    [v-cloak] {
        display:none;
    }
</style>
<div class="register-view"  id="update-register" v-cloak>
    <div class="text-right">

        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger btn-sm',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </div>

    <div class="row" >
        <div class="col-md-8">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title">ข้อมูลสมาชิก <?= @$model->getFullName() ?></h3>
                </div>
                <div class="panel-body">
                    <?= $this->render('_form', [
                        'model' => $model,
                    ]) ?>

                </div>
            </div>

        </div>
        <div class="col-md-4">
            <div class="panel panel-warning">
                <div class="panel-heading">
                    <h3 class="panel-title">สรุปค่าชำระ</h3>
                </div>
                <div class="panel-body">
                    <?php
                    $total =0;
                    $send=!empty($model->send_price)?$model->send_price :0;
                   $total = $model->amount_price + $send
                    ?>
                    <ul class="list-group">
                        <li class="list-group-item"><h4>สถานะการรับ :  <?=@$model->DeliveryName?></h4></li>
                        <?php if($model->delivery_status ==1):?>
                            <li class="list-group-item"><h4>หลักฐานการชำระ : <a href="<?=$model->slip?>"> ลิงค์ดูหลักฐาน</a></h4></li>
                        <?php endif;?>
                        <li class="list-group-item"><h4>ค่าจัดส่ง :  <?=@$model->send_price?></h4></li>
                        <li class="list-group-item"><h4>ยอดรวมทั้งหมด : <?=@number_format($total,0)?> </h4></li>

                    </ul>

                </div>
            </div>
            <div class="panel panel-success">
                <div class="panel-heading">
                    <h3 class="panel-title">สรุปรายการ</h3>
                </div>
                <div class="panel-body">
                    <?php
                    $sql = "SELECT size_shirts,COUNT (size_shirts) AS sum_size FROM register WHERE register_id=:register_id OR ID=:id GROUP BY size_shirts";
                    $query = Yii::$app->db->createCommand($sql)->bindValues(['register_id' => $model->id, 'id' => $model->id])->queryAll();

                    ?>
                    <h4>รายการประเภท</h4>
                    <table class="table table-bordered table-hover">
                        <thead>
                        <tr>
                            <th>ชื่อรายการ</th>
                            <th>จำนวน</th>
                        </tr>
                        </thead>
                        <?php foreach (Yii::$app->db->createCommand("SELECT type_register,COUNT (type_register) AS sum_type_register FROM register WHERE register_id = :register_id OR ID=:id GROUP BY type_register")->bindValues(['register_id' => $model->id, 'id' => $model->id])->queryAll() as $Qmodel): ?>
                            <tr>
                                <td><?= @$Qmodel['type_register'] ?></td>
                                <td><?= @$Qmodel['sum_type_register'] ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </table>
                    <hr>
                    <h4>รายการระยะทาง</h4>
                    <table class="table table-bordered table-hover">
                        <thead>
                        <tr>
                            <th>ชื่อรายการ</th>
                            <th>จำนวน</th>
                        </tr>
                        </thead>
                        <?php foreach (Yii::$app->db->createCommand("SELECT type_run,COUNT (type_run) AS sum_type_run FROM register WHERE register_id = :register_id OR ID=:id GROUP BY type_run")->bindValues(['register_id' => $model->id, 'id' => $model->id])->queryAll() as $Qmodel): ?>
                            <tr>
                                <td><?= @$model->getTypeRunNameKey($Qmodel['type_run']) ?></td>
                                <td><?= @$Qmodel['sum_type_run'] ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </table>
                    <hr>
                    <h4>รายการขนาดเสื้อ</h4>
                    <table class="table table-bordered table-hover">
                        <thead>
                        <tr>
                            <th>ชื่อรายการ</th>
                            <th>จำนวน</th>
                        </tr>
                        </thead>
                        <?php foreach ($query as $Qmodel): ?>
                            <tr>
                                <td><?= @$Qmodel['size_shirts'] ?></td>
                                <td><?= @$Qmodel['sum_size'] ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </table>

                </div>
            </div>
        </div>
    </div>

    <div v-if="showModal">

        <transition name="modal">
            <div class="modal-mask">
                <div class="modal-wrapper">
                    <div class="modal-dialog  modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" @click="showModal=false">
                                    <span aria-hidden="true"><i class="glyphicon glyphicon-remove text-danger"></i></span>
                                </button>
                                <h4 class="modal-title">เพิ่มข้อมูล <code> กรุณาใส่ข้อมูลให้ครบทุกช่อง</code></h4>
                            </div>
                            <div class="modal-body">
                               <div class="row">
                                   <div class="col-md-4">
                                       <div class="form-group">
                                           <label for="exampleInputEmail1">ชื่อ</label>
                                           <input type="text" class="form-control"  placeholder="ชื่อ" v-model="dataTeam.firstname">
                                       </div>
                                   </div>
                                   <div class="col-md-4">
                                       <div class="form-group">
                                           <label for="exampleInputEmail1">นามสกุล</label>
                                           <input type="text" class="form-control"  placeholder="นามสกุล"  v-model="dataTeam.lastname">
                                       </div>
                                   </div>
                                   <div class="col-md-4">
                                       <label for="exampleInputEmail1">เพศ</label> <br>
                                       <button-group   type="primary"  v-model="dataTeam.sex">
                                           <radio selected-value="1 ">ชาย</radio>
                                           <radio selected-value="2">หญิง</radio>
                                       </button-group>
                                   </div>

                               </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        <label for="exampleInputEmail1">วันเกิด</label>
                                        <code>ตัวอย่าง 12/02/2540</code>

                                        <input type="date" class="form-control" v-model="dataTeam.birthday" @input="Calage(dataTeam.birthday)">
                                    </div>

                                    <div class="col-md-8">
                                        <label for="exampleInputEmail1">เลขบัตรประชาชน</label>
                                        <input type="text" class="form-control"  v-model="dataTeam.id_card" @change="checkCard(dataTeam.id_card)" maxlength="13">
                                    </div>

                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="exampleInputEmail1">ประเภทการสมัคร</label> <br>
                                        <button-group   type="primary"  v-model="dataTeam.type_register" v-for="tr in ty_register">
                                            <radio :selected-value="tr.name">{{tr.name}}</radio>
                                        </button-group>
                                        <br>

                                        <label for="exampleInputEmail1">ระยะ</label> <br>
                                        <button-group   type="primary"  v-model="dataTeam.type_run" >
                                            <radio :selected-value="3"> 3 K</radio>
                                            <radio :selected-value="5">5 K</radio>
                                            <radio :selected-value="10">10 K</radio>
                                        </button-group>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="exampleInputEmail1">ขนาดเสื้อ</label> <br>
                                        <button-group   type="primary"  v-model="dataTeam.size_shirts" v-for="tys in ty_shirts">
                                            <radio :selected-value="tys.val"> {{tys.name}}</radio>
                                        </button-group>

                                    </div>
                                    <div class="col-md-12">
                                        <div class="text-right">
                                            <button class="btn btn-success btn-lg" :disabled="!check_card" @click="SavedataAdd"
                                            >บันทึกข้อมูล</button>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </transition>
    </div>
    </div>
<?php
$ref_data = \ext\modules\runner\models\Register::find()->where(['register_id' => $model->id])->orderBy('id desc')->all();
$data_model = \yii\helpers\Json::encode($model);
$data_ref = \yii\helpers\Json::encode($ref_data);
$Url =\yii\helpers\Url::to(['register/update-register']);
$url_card =\yii\helpers\Url::to(['default/id-card']);
$url_SaveAdd =\yii\helpers\Url::to(['default/save-add']);
$url_Delete =\yii\helpers\Url::to(['default/delete-team']);
$id= Yii::$app->request->get('id');
$JS = <<<JS
var app = new Vue({
    el:"#update-register",
 components: {
      vSelect: VueStrap.select,
      BsInput:VueStrap.input,
      ButtonGroup:VueStrap.buttonGroup,
      radio:VueStrap.radio,
       checkbox:VueStrap.checkbox,
       datepicker:VueStrap.datepicker,
       alert:VueStrap.alert
    },
    data:{
        check_card: false,
        edit_full:false,
        showModal:false,
        show:true,
         age:'',
        dataTeam:{},
        model_data:$data_model,
        ref_data:$data_ref,
        ty_register:[
            {"name":"นักเรียน"},
            {"name":"นักเรียน รับเสื้อ"},
            {"name":"บุคคลทั่วไป"},
            {"name":"vip"},
            {"name":"แฟนซี"}
        ],
        ty_shirts:[
          {'val':'SS',"name":'SS(34)'} , 
          {'val':'S',"name":'S(36)'} ,
          {'val':'M',"name":'M(38)'} ,  
          {'val':'L',"name":'L(40)'} , 
          {'val':'XL',"name":'XL(42)'} , 
          {'val':'2XL',"name":'2XL(44)'} , 
          {'val':'3XL',"name":'2XL(48)'} , 
        ],
       
    },
    computed:{
       
    },
   
    methods:{
        removeTeam(model){
            jQuery.post("$url_Delete",{data:model.id,id:"$id"},function(data){
                console.log(data)
            });
        },
        checkCard(model){
            var vm = this;
            var dataJson =JSON.stringify( {citizen:model});
            jQuery.post("$url_card",{citizen:model},function(data){
                if(data.status== "false"){
                 swal({
                    title:"รหัสบัตรไม่ถูกต้อง",
                    text:"กรุณากรอกข้อมูลให้ถูกต้อง",
                    icon: "warning",
                    timer: 2000,
                    button:false,
                  });
                 vm.check_card = false;
                }else  if (data.status== "success" && data.existing){
                    vm.check_card = false;
                     swal({
                        title:"รหัสบัตรมีการใช้งานอยู่",
                        text:"กรุณากรอกข้อมูลให้ถูกต้อง",
                        icon: "info",
                        timer: 2000,
                        button:false,
                     });
                }else {
                     vm.check_card = true;
                }
             });
        },
         Calage(data){
            var year=data.substr(0,4)-543;
            var d = new Date();
           var full_Year= d.getFullYear();
           var getAge = full_Year - year ;
           if(getAge != null){
               this.age =getAge;
           }
            console.log(getAge);
        },
        Check(model){
            console.log(model);
            jQuery.post("$url_card",{citizen:model},function(data){
                console.log(data)
            });
        },
        saveData(){
            var con =confirm("ต้องการแก้ไขหรือเปลี่ยนแปลงใช่ หรือไม่ ?");
            var vm = this;
            if(con){
             jQuery.post("$Url",{data:vm.model_data},function(data){
                 console.log(data)
             });
             }
        },
        SavedataAdd(){
            var vm =this;
               jQuery.post("$url_SaveAdd",{data:JSON.stringify(this.dataTeam),id:"$id"},function(data){
                console.log(data)
            });
        },
        updateEdit(item){
            console.log(item)
//            jQuery.post("$Url",{data:item},function(data){
//                 console.log(data)
//             });
        },
        Update(model){
            var con =confirm("ต้องการแก้ไขหรือเปลี่ยนแปลงใช่ หรือไม่ ?");
            if(con){
             jQuery.post("$Url",{data:model},function(data){
                 console.log(data)
             });
            }
        }
    }
})
JS;

$this->registerJS($JS);
?>