<?php

use yii\db\Migration;

/**
 * Class m180305_174746_register
 */
class m180305_174746_register extends Migration
{

    public function up()
    {
        $this->createTable('register',[
            'id'=>$this->primaryKey(),
            'register_id'=>$this->integer(),
            'firstname'=>$this->string(),
            'lastname'=>$this->string(),
            'sex'=>$this->smallInteger(),
            'birthday'=>$this->date(),
            'id_card'=>$this->string(),
            'age'=>$this->integer(),
            'phone'=>$this->string(),
            'email'=>$this->string(),
            'club'=>$this->string(),
            'status'=>$this->smallInteger(), //สภานะการสมัคร /จ่ายเงิน
            'delivery_status'=>$this->smallInteger(), //สถานะการสงของ
            'send_status'=>$this->smallInteger(),  //สถานะการส่ง หรือ รับเอง
            'type_group'=>$this->smallInteger(),   //ประเภทกลุ่ม
            'emergency_name'=>$this->string(),
            'emergency_phone'=>$this->string(),
            'type_register'=>$this->string(),
            'type_run'=>$this->string(),
            'size_shirts'=>$this->string(),

            'slip'=>$this->string(),
            'send_price'=>$this->float(),
            'amount_price'=>$this->float(),

            'address'=>$this->string(),
            'house_no'=>$this->string(), //หมุ่
            'soi'=>$this->string(), //ซอย
            'street'=>$this->string(), //ถนน
            'district'=>$this->string(),  //คำบล
            'amphoe'=>$this->string(),    //อำเภท
            'province'=>$this->string(),  //จังหวัด
            'zipcode'=>$this->string(),

            'created_at' => $this->timestamp(),
            'updated_at' => $this->timestamp(),
            'created_by' => $this->integer(),
            'updated_by' => $this->integer(),
        ]);
    }
    public function down()
    {
        $this->dropTable('{{register}}');
    }
}
