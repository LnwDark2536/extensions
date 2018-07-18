<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;


?>

    <div class="register-form" >

        <?php $form = ActiveForm::begin(); ?>
        <h3>ข้อมูลส่วนตัว</h3>
        <hr>
        <div class="row">
            <div class="col-md-6">
                <?= $form->field($model, 'firstname')->textInput(['maxlength' => true]) ?>
                <?= $form->field($model, 'sex')->radioList($model->getItemSex()) ?>
                <?= $form->field($model, 'id_card')->textInput(['maxlength' => true]) ?>

            </div>
            <div class="col-md-6">
                <?= $form->field($model, 'lastname')->textInput(['maxlength' => true]) ?>
                <?= $form->field($model, 'birthday')->textInput(['type' => 'date']) ?>
                <?= $form->field($model, 'age')->textInput() ?>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>
                <?= $form->field($model, 'emergency_name')->textInput(['maxlength' => true]) ?>

            </div>
            <div class="col-md-6">
                <?= $form->field($model, 'phone')->textInput() ?>
                <?= $form->field($model, 'emergency_phone')->textInput(['maxlength' => true]) ?>
            </div>
            <div class="col-md-4">
                <?= $form->field($model, 'club')->textInput(['maxlength' => true])->label('ทีม') ?>

            </div>
            <div class="col-md-4">
                <?= $form->field($model, 'send_price')->textInput(['maxlength' => true])->label('ราคาส่ง') ?>
            </div>
            <div class="col-md-4">
                <?= $form->field($model, 'amount_price')->textInput()->label('ยอดชำระ') ?>
            </div>
        </div>



        <h3>ข้อมูลรายละเอียดการสมัคร</h3>
        <?php if(!empty($model->club)):?>
        <div class="text-right">
           <h4 > ทีม: <span ><?=$model->club?></span></h4>
        </div>
<?php endif;?>
        <hr>

<div class="text-right">
    <div id="show-modal" @click="showModal = true" class="btn btn-primary btn-sm" ><i class="glyphicon glyphicon-plus"></i>เพิ่มข้อมูลทีม</div>

</div>
        <div >
            <table class="table table-bordered table-hover">
                <thead>
                <tr class="default">
                    <th>ชื่อ - นามสกุล</th>
                    <th>รายการประเภท</th>
                    <th>ระยะ</th>
                    <th>ขนาดเสื้อ</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td> {{model_data.firstname}} {{model_data.lastname}}
                        <i class="glyphicon glyphicon-star text-warning"></i> <br>
                        <span style="font-size: 12px">{{model_data.id_card}}</span>
                    </td>
                    <td>
                        <select class="form-control" v-model="model_data.type_register" @change="Update(model_data)">
                            <option v-for="mr in ty_register">{{mr.name}}</option>
                        </select>
                    </td>
                    <td>
                        <select class="form-control" v-model="model_data.type_run" @change="Update(model_data)">
                            <option value="3">3 กิโลเมตร</option>
                            <option value="5">5 กิโลเมตร</option>
                            <option value="10">10 กิโลเมตร</option>
                        </select>
                    </td>
                    <td>
                        <select class="form-control" v-model="model_data.size_shirts" @change="Update(model_data)">
                            <option v-for="shir in ty_shirts" :value="shir.val">{{shir.name}}</option>
                        </select>
                    </td>

                </tr>

                <tr v-if="ref_data.length > 0" v-for="rmd in ref_data">

                    <td>{{rmd.firstname}} {{rmd.lastname}} <br>
                        <span style="font-size: 12px">{{rmd.id_card}}</span>
                    </td>
                    <td>
                        <select class="form-control" v-model="rmd.type_register" @change="Update(rmd)">
                            <option v-for="mr in ty_register">{{mr.name}}</option>
                        </select>
                    </td>
                    <td>
                        <select class="form-control" v-model="rmd.type_run" @change="Update(rmd)">
                            <option value="3">3 กิโลเมตร</option>
                            <option value="5">5 กิโลเมตร</option>
                            <option value="10">10 กิโลเมตร</option>
                        </select>
                    </td>
                    <td>
                        <select class="form-control" v-model="rmd.size_shirts" @change="Update(rmd)">
                            <option v-for="shir in ty_shirts" :value="shir.val">{{shir.name}}</option>
                        </select>
                    </td>
                    <td>
                        <i class="glyphicon glyphicon-trash  " @click="removeTeam(rmd)"></i>
                    </td>
                </tr>

                </tbody>
            </table>
        </div>

        <div class="form-group text-right">
            <?= Html::submitButton('บันทึกข้อมูล', ['class' => 'btn btn-success']) ?>
        </div>
        <?php ActiveForm::end(); ?>
    </div>

