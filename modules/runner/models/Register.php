<?php

namespace ext\modules\runner\models;

use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "register".
 *
 * @property int $id
 * @property int $register_id
 * @property string $firstname
 * @property string $lastname
 * @property int $sex
 * @property string $birthday
 * @property string $id_card
 * @property string $phone
 * @property string $email
 * @property string $club
 * @property int $status
 * @property int $delivery_status
 * @property int $send_status
 * @property int $type_group
 * @property string $emergency_name
 * @property string $emergency_phone
 * @property string $type_register
 * @property string $type_run
 * @property string $size_shirts
 * @property string $slip
 * @property double $send_price
 * @property double $amount_price
 * @property string $address
 * @property string $house_no
 * @property string $soi
 * @property string $street
 * @property string $district
 * @property string $amphoe
 * @property string $province
 * @property string $zipcode
 * @property string $created_at
 * @property string $updated_at
 * @property int $created_by
 * @property int $updated_by
 */
class Register extends \yii\db\ActiveRecord
{
    public $price_send = 56;

    public static function tableName()
    {
        return 'register';
    }

    public function behaviors()
    {
        return [
            BlameableBehavior::className(),
            [
                'class' => TimestampBehavior::className(),
                'createdAtAttribute' => 'created_at',
                'updatedAtAttribute' => 'updated_at',
                'value' => new Expression('NOW()'),
            ],
        ];
    }

//
    public function rules()
    {
        return [
            ['id_card', 'unique', 'targetClass' => 'ext\modules\runner\models\Register', 'message' => 'มีเลขบัตรประชาชนใช้งานแล้ว !'],
            ['id_card', 'string', 'max' => 13],
            [['birthday', 'created_at', 'updated_at', 'sex', 'phone', 'status', 'delivery_status', 'send_status', 'type_group', 'created_by', 'updated_by', 'firstname', 'lastname', 'id_card', 'email', 'club', 'emergency_name', 'emergency_phone', 'type_register', 'type_run', 'size_shirts', 'slip', 'house_no', 'address', 'soi', 'street', 'district', 'amphoe', 'province', 'zipcode', 'register_id', 'send_price', 'amount_price', 'age'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'firstname' => 'ชื่อ',
            'lastname' => 'นามสกุล',
            'fullName' => 'ชื่อ - นามสกุล',
            'sex' => 'เพศ',
            'birthday' => 'วัน-เดือน-ปี-เกิด',
            'id_card' => 'เลขประจำตัวประชาชน',
            'phone' => 'Phone',
            'email' => 'Email',
            'age' => 'อายุ',
            'club' => 'Club',
            'status' => 'Status',
            'delivery_status' => 'Delivery Status',
            'send_status' => 'Send Status',
            'type_group' => 'Type Group',
            'emergency_name' => 'ขื่อผู้ติดต่อกรณีฉุกเฉิน',
            'emergency_phone' => 'เบอร์มือถือผู้ติดต่อกรณีฉุกเฉิน',
            'type_register' => 'ประเภทสมัคร',
            'type_run' => 'ระยะ',
            'size_shirts' => 'ขนาดเสื้อ',
            'slip' => 'Slip',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
        ];
    }


    public function getFullName()
    {
        return $this->firstname . ' ' . $this->lastname;
    }

    public function getAge()
    {
        $year = date('Y') + 543;
        $SubBirthday = substr($this->birthday, 0, 4);
        if (!empty($SubBirthday)) {
            return $year - $SubBirthday;
        } else {
            return 0;
        }

    }

    public static function itemsAlias($key)
    {
        $items = [
            'sex' => [
                1 => 'ชาย',
                2 => 'หญิง'
            ],
            'status' => [
                0 => 'ยังไม่ชำระ',
                1 => '<i class="glyphicon glyphicon-ok text-success"></i> ชำระแล้ว ',
            ],
            'delivery_status' => [
                1 => ' ส่งไปรษณีย์ ',
                2 => ' มารับเอง '
            ],
            'type_register' => [
                1 => 'นักเรียน (200 บาท)',
                2 => 'ประชาชน (400 บาท)',
                3 => 'VIP (1,000 บาท)',
                4 => 'แฟนซี (400 บาท)',
            ],
            'type_regis_price' => [
                'นักเรียน' => 200,
                'บุคคลทั่วไป' => 400,
                'ประชาชน' => 400,
                'vip' => 1000,
                'แฟนซี' => 400,
            ],
            'type_run' => [
                3 => '3 Km.',
                5 => '5 Km.',
                10 => '10 Km.',
            ],
            'size_shirts' => [
                'SS' => 'SS (34")',
                'S' => 'S (36")',
                'M' => 'M (38")',
                'L' => 'L (40")',
                'XL' => 'XL (42")',
                '2XL' => '2XL (44")',
                '3XL' => '3XL (46")',
            ],

        ];
        return ArrayHelper::getValue($items, $key, []);
    }

    public function getItemSizeShirts()
    {
        return self::itemsAlias('size_shirts');
    }

    
    public function getItemSex()
    {
        return self::itemsAlias('sex');
    }

    public function getItemDelivery()
    {
        return self::itemsAlias('delivery_status');
    }

    

    public function getItemRun()
    {
        return self::itemsAlias('type_run');
    }

    public function getItemStatus()
    {
        return self::itemsAlias('status');
    }

    public function getItemPrice()
    {
        return self::itemsAlias('status');
    }

    public static function getSex($sex){
       $data = [
            1 => 'ชาย',
            2 => 'หญิง'
        ];
        return ArrayHelper::getValue($data, $sex);
    }
    public static function getRun($run){
        $data = [
            3 => '3 Km.',
            5 => '5 Km.',
            10 => '10 Km.',
        ];
        return ArrayHelper::getValue($data, $run);
    }
    public static function getDelivery($check){
        $data = [
            1 => ' ส่งไปรษณีย์ ',
            2 => ' มารับเอง '
        ];
        return ArrayHelper::getValue($data, $check);
    }
    public static function getGen($register,$run,$age){

        if ($register == "นักเรียน" || $register == "นักเรียน รับเสื้อ") {
            if ($run == 10) {
                return "ไม่เกิน 19 ปี";
            } else {
                if ($age <= 12) {
                    return "ตำ่กว่า 12 ปี";
                } else if ($age >= 13 && $age <= 14) {
                    return "13 -14 ปี";
                } else if ($age >= 15 && $age <= 16) {
                    return "15 -16 ปี";
                } else if ($age >= 17 && $age <= 18) {
                    return "17 -18 ปี";
                }
            }
        }
        else{
            if ($age <= 19) {
                return "ไม่เกิน 19 ปี";
            } else if ($age >= 60) {
                return "60 ปีขึ้นไป";
            } else if ($age >= 20 && $age <= 29) {
                return "20 -29 ปี";
            } else if ($age >= 30 && $age <= 39) {
                return "30 -39 ปี";
            } else if ($age >= 40 && $age <= 49) {
                return "40 -49 ปี";
            } else if ($age >= 50 && $age <= 59) {
                return "50 -59 ปี";
            }
        }
    }

    public function getSexName()
    {
        return ArrayHelper::getValue($this->getItemSex(), $this->sex);
    }

    public function getTypeStatusName()
    {
        return ArrayHelper::getValue($this->getItemStatus(), $this->status);
    }

    public function getTypeRunName()
    {
        return ArrayHelper::getValue($this->getItemRun(), $this->type_run);
    }

    public function getDeliveryName()
    {
        return ArrayHelper::getValue($this->getItemDelivery(), $this->delivery_status);
    }

    public function getTypeRunNameKey($key)
    {
        return ArrayHelper::getValue($this->getItemRun(), $key);
    }

    public function getPrice()
    {
        return self::itemsAlias('type_regis_price');
    }

    public function getPriceRegister($data)
    {
        return ArrayHelper::getValue($this->getPrice(), $data);
    }

    public function getTypeShirtsName()
    {
        return ArrayHelper::getValue($this->getItemSizeShirts(), $this->size_shirts);
    }

    public function getCitizenName()
    {
        $c = $this->id_card;
        $spacer = ' ';
        if (strlen($c) == 13) {
            return substr($c, 0, 1) . $spacer . substr($c, 1, 4) . $spacer . substr($c, 5, 5) . $spacer . substr($c, 10, 2) . $spacer . $c[12];
        }
        return $this->id_card;
    }

    // รวมราคา
    public function getCalAllSend($status, $totalAll)
    {
        if ($status == 1) {
            return $totalAll + $this->price_send;
        } else {
            return $totalAll;
        }
    }

    public function getGenName()
    {
        if ($this->type_register == "นักเรียน" || $this->type_register == "นักเรียน รับเสื้อ") {
            if ($this->type_run == 10) {
                return "ไม่เกิน 19 ปี";
            } else {
                if ($this->age <= 12) {
                    return "ตำ่กว่า 12 ปี";
                } else if ($this->age >= 13 && $this->age <= 14) {
                    return "13 -14 ปี";
                } else if ($this->age >= 15 && $this->age <= 16) {
                    return "15 -16 ปี";
                } else if ($this->age >= 17 && $this->age <= 18) {
                    return "17 -18 ปี";
                }
            }
        }
        else{
                if ($this->age <= 19) {
                    return "ไม่เกิน 19 ปี";
                } else if ($this->age >= 60) {
                    return "60 ปีขึ้นไป";
                } else if ($this->age >= 20 && $this->age <= 29) {
                    return "20 -29 ปี";
                } else if ($this->age >= 30 && $this->age <= 39) {
                    return "30 -39 ปี";
                } else if ($this->age >= 40 && $this->age <= 49) {
                    return "40 -49 ปี";
                } else if ($this->age >= 50 && $this->age <= 59) {
                    return "50 -59 ปี";
                }
            }
        }

    }
