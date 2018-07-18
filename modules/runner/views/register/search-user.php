<style>
    .ta-size{
        font-size: 20px;
        font-weight: bold;
    }
    [v-cloak] {
        display: none;
    }
</style>
<div class="search-user">
<div class="container" id="search-user" v-cloak>
    <div class="panel panel-primary">
        <div class="panel-heading">
            <h3 class="panel-title">ตรวจสอบการรับสินค้า ({{filterShow.length}})</h3>
        </div>
        <div class="panel-body">
            <div class="form-group row">
                <div class=" col-md-4">
                    <input type="text" class="form-control input-lg"  ref='search' autofocus v-model="search"
                           placeholder="ค้นหารหัสผู้สมัคร หรือ เบอร์โทร ">
                    <table class="table table-bordered table-hover" width="100%">
                        <thead>
                        <tr>
                            <th width="10%">#</th>
                            <th width="60%">ชื่อ-นามสกุล</th>
                            <th width="10%"><i class="glyphicon glyphicon-upload"></i></th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="(model,index) in filterShow.slice(0, 10)" @click="View(model.id)" :class="check(model)">
                            <td>{{index+1}}</td>
                            <td>{{model.firstname}} {{model.lastname}}</td>
                            <td>
                                <i  v-if="model.status ==1" class="glyphicon glyphicon-thumbs-down text-danger" @click="View(model.id)"></i>
                                <i  v-if="model.status ==6" class="glyphicon glyphicon-thumbs-up " @click="View(model.id)"></i>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <div class="col-md-8">
                    <div class="panel panel-default" v-for="(model,index) in viewData">
                        <div class="panel-heading">
                            <h3 class="panel-title ">
                                <label>คุณ{{model.firstname}} {{model.lastname}}</label>
                            </h3>
                        </div>
                        <div class="panel-body">
                            <div class="text-right"  v-if="model.status==1">
                                <button class="btn btn-success " @click="SaveData(model)"><i class="glyphicon glyphicon-ok"></i> บันทึกรับของ</button>
                            </div>
                            <div class="text-right"  v-if="model.status ==6">
                                <button class="btn btn-success" disabled><i class="glyphicon glyphicon-remove"></i> มารับสินค้าแล้ว</button>
                            </div>
                            <div class="row" >
                                <div class="col-md-8">
                                    <table class="table table-bordered table-hover">
                                        <thead>
                                        <tr>
                                            <th width="30%">ชื่อ - นามสกุล</th>
                                            <td>{{model.firstname}} {{model.lastname}}</td>
                                        </tr>
                                        <tr>
                                            <th>เลขประจำตัว</th>
                                            <td>
                                                {{model.id_card}}
                                            </td>
                                            <td>
                                                อายุ {{model.age}}
                                            </td>
                                        </tr>
                                        <tr v-if="model.club != null">
                                            <th>ทีม</th>
                                            <th>{{model.club}}</th>
                                        </tr>
                                        <tr v-if="model.address != null">
                                            <th >ที่อยู่</th>
                                            <td>
                                                <span v-if="model.address != null">{{model.address}}</span>
                                                <span v-if="model.house_no != null">ม.{{model.house_no}}</span>
                                                <span v-if="model.street != null">ถ.{{model.street}}</span>
                                                <span v-if="model.street != null">ถ.{{model.street}}</span><br>
                                                <span v-if="model.district != null">ต.{{model.district}}</span>
                                                <span v-if="model.amphoe != null">อ.{{model.amphoe}}</span>
                                                <span v-if="model.province != null">จ.{{model.province}} {{model.zipcode}}</span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>เบอร์ติดค่อ</th>
                                            <td>
                                                {{model.phone}}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>อีเมล์</th>
                                            <td>
                                                {{model.email}}
                                            </td>
                                        </tr>
                                        <tr v-if="model.slip !=null">
                                            <th>หลักฐานการชำระ</th>
                                            <td>
                                                <a :href="model.slip">ลิงค์หลักฐานการชำระ</a>
                                            </td>
                                        </tr>
                                        </thead>
                                    </table>
                                    <hr>
                                    <h4> ข้อมูลรายละเอียดการสมัคร</h4>
                                    <table class="table table-bordered table-hover">
                                        <thead>
                                        <tr class="active">
                                            <th>ชื่อ - นามสกุล</th>
                                            <th>รายการประเภท</th>
                                            <th>ระยะ</th>
                                            <th>อายุ</th>
                                            <th>เพศ</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr>
                                            <td>{{model.firstname}} {{model.lastname}} <i class="glyphicon glyphicon-star text-warning"></i></td>
                                            <td >{{model.type_register}}</td>
                                            <td>{{model.type_run}}</td>
                                            <td>{{model.age}}</td>
                                            <td>{{model.sex | checkSex}}</td>
                                        </tr>
                                        <tr v-if="DetailsRegister.length > 0" v-for="details in DetailsRegister" >
                                            <td>{{details.firstname}} {{details.lastname}}</td>
                                            <td>{{details.type_register}}</td>
                                            <td>{{details.type_run}}</td>
                                            <td>{{details.age}}</td>
                                            <td>{{details.sex | checkSex}}</td>
                                        </tr>
                                        </tbody>
                                    </table>

                                </div>
                                <div class="col-md-4">
                                    <table class="table table-bordered table-hover">
                                        <thead>
                                        <tr class="warning">
                                            <th>ขนาดเสื้อ</th>
                                            <th style="text-align: right;">จำนวน</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr v-for="Shirts in DataShirts">
                                            <td class="ta-size">{{Shirts.size_shirts}}</td>
                                            <td class="ta-size text-right">{{Shirts.sum_size}}</td>
                                        </tr>
                                        </tbody>
                                    </table>
                                    <hr>
                                    <div class="panel panel-warning">
                                        <div class="panel-body">
                                            <h2>ราคา {{model.amount_price+model.send_price}}</h2>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <hr>
        </div>
    </div>
</div>
<?php
\app\assets\UseAppAsset::register($this);
?>