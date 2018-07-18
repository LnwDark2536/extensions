<?php

namespace ext\modules\runner\controllers;

use app\models\User;
use ext\modules\runner\models\Register;
use Yii;
use yii\filters\auth\HttpBasicAuth;
use yii\filters\Cors;
use yii\helpers\ArrayHelper;
use yii\web\Response;

class ApiController extends \yii\rest\Controller
{

    public $identity;

    protected function verbs()
    {
        return [
            'index' => ['POST', 'OPTIONS'],
        ];
    }

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['contentNegotiator']['formats']['text/html'] = Response::FORMAT_JSON;
        $behaviors['authenticator'] = [
            'class' => HttpBasicAuth::className(),
            'auth' => [$this, 'auth'],
        ];

        return ArrayHelper::merge([
            [
                'class' => Cors::className(),
                'cors' => [
                    'Access-Control-Request-Method' => ['GET', 'HEAD', 'OPTIONS'],
                ],
            ],
        ], $behaviors);

        // return $behaviors;
    }

    public function auth($username, $password)
    {
        $user = User::findByUsername($username);
        if ($user && $user->validatePassword($password)) {
            return $user;
        }
    }

    public function actions()
    {
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Headers: authorization, content-type');

        return parent::actions();
    }

    public function actionTest()
    {
        if ($post = \Yii::$app->request->rawBody) {
            $response = [
                "status" => 'success',
                "data" => $post,
            ];
            return $response;
        }

        return [];
    }

    public function actionRegister()
    {
        if ($dataPost = \Yii::$app->request->rawBody) {
            $dataJsonPost = json_decode($dataPost, true);
            $ref_id = '';
            if (isset($dataJsonPost)) {
                foreach ($dataJsonPost as $array1) {
                    if (count($array1) > 1) {
                        foreach ($array1 as $k => $model) {
                            if ($k == 0) {
                                $register = new Register();
                                $register->firstname = isset($model['info']['firstname']) ? $model['info']['firstname'] : '';
                                $register->lastname = isset($model['info']['lastname']) ? $model['info']['lastname'] : '';
                                $register->sex = $model['info']['gender'] == 'male' ? 1 : 2;
                                $register->birthday = isset($model['info']['dob']) ? $model['info']['dob'] : '';
                                $register->age = isset($model['info']['age']) ? $model['info']['age'] : '';
                                $register->id_card = isset($model['info']['citizen']) ? $model['info']['citizen'] : '';
                                $register->email = isset($model['info']['email']) ? $model['info']['email'] : '';
                                $register->phone = isset($model['info']['mobile']) ? $model['info']['mobile'] : '';
                                $register->delivery_status = $model['info']['shipmethod'] == 'post' ? 1 : 2;
                                $register->emergency_name = isset($model['info']['emer_person']) ? $model['info']['emer_person'] : '';
                                $register->emergency_phone = isset($model['info']['emer_contact']) ? $model['info']['emer_contact'] : '';
                                $register->type_register = isset($model['info']['type']) ? $model['info']['type'] : '';// ประเภท
                                $register->type_run = isset($model['info']['distance']) ? $model['info']['distance'] : '';
                                $register->size_shirts = isset($model['info']['size']) ? $model['info']['size'] : '';
                                $register->type_group = 2; //สมัครทีม
                                $register->club = isset($model['info']['team']) ? $model['info']['team'] : '';
                                if ($model['info']['shipmethod'] == 'post') {
                                    $register->address = isset($model['address']['address']) ? $model['address']['address'] : '';
                                    $register->house_no = isset($model['address']['moo']) ? $model['address']['moo'] : '';
                                    $register->soi = isset($model['address']['soi']) ? $model['address']['soi'] : '';
                                    $register->street = isset($model['address']['street']) ? $model['address']['street'] : '';
                                    $register->district = isset($model['address']['subDistrict']) ? $model['address']['subDistrict'] : '';
                                    $register->amphoe = isset($model['address']['district']) ? $model['address']['district'] : '';
                                    $register->province = isset($model['address']['province']) ? $model['address']['province'] : '';
                                    $register->zipcode = $model['address']['zipcode'];
                                }

                                $register->type_group = 2; //สมัครทีม
                                $register->slip = isset($model['payment']['url']) ? $model['payment']['url'] : '';
                                $register->send_price = isset($model['payment']['fee']) ? $model['payment']['fee'] : '';
                                $register->amount_price = isset($model['payment']['amount']) ? $model['payment']['amount'] : '';
                                $register->status = 0;
                                if ($register->save()) {
                                    $ref_id = $register->id;
                                }
                                if (!empty($register->errors)) {
                                    $response = [
                                        "status" => 'not',
                                        'text'=>'primary not',
                                        "data" => [],
                                    ];
                                    break;
                                }

                            } else {
                                $register_ref = new Register();
                                $register_ref->register_id = $ref_id;
                                $register_ref->firstname = isset($model['info']['firstname']) ? $model['info']['firstname'] : '';
                                $register_ref->lastname = isset($model['info']['lastname']) ? $model['info']['lastname'] : '';
                                $register_ref->sex = $model['info']['gender'] == 'male' ? 1 : 2;
                                $register_ref->birthday = isset($model['info']['dob']) ? $model['info']['dob'] : '';
                                $register_ref->age = isset($model['info']['age']) ? $model['info']['age'] : '';
                                $register_ref->id_card = isset($model['info']['citizen']) ? $model['info']['citizen'] : '';
                                $register_ref->type_register = isset($model['info']['type']) ? $model['info']['type'] : ''; // ประเภท
                                $register_ref->type_run = isset($model['info']['distance']) ? $model['info']['distance'] : '';
                                $register_ref->size_shirts = isset($model['info']['size']) ? $model['info']['size'] : '';
                                $register_ref->save();
                            }
                            if (!empty($register_ref->errors)) {
                                Register::findOne(['id' => $ref_id])->delete();
                                $response = [
                                    "status" => 'not',
                                    'text'=>'team not',
                                    "data" => [],
                                ];
                                break;

                            } else {
                                 $response = [
                                    "status" => 'success',
                                    "data" => $array1,
                                ];
                            }
                        }
                        return $response;
//                            return $response = [
//                                "status" => 'success',
//                                "data" => $array1,
//                            ];
                    } else {
                        foreach ($array1 as $getModel2) {
                            $register = new Register();
                            $register->firstname = isset($getModel2['info']['firstname']) ? $getModel2['info']['firstname'] : '';
                            $register->lastname = isset($getModel2['info']['lastname']) ? $getModel2['info']['lastname'] : '';
                            $register->sex = $getModel2['info']['gender'] == 'male' ? 1 : 2;
                            $register->birthday = isset($getModel2['info']['dob']) ? $getModel2['info']['dob'] : '';
                            $register->age = isset($getModel2['info']['age']) ? $getModel2['info']['age'] : '';
                            $register->id_card = isset($getModel2['info']['citizen']) ? $getModel2['info']['citizen'] : '';
                            $register->email = isset($getModel2['info']['email']) ? $getModel2['info']['email'] : '';
                            $register->phone = isset($getModel2['info']['mobile']) ? $getModel2['info']['mobile'] : '';
                            $register->delivery_status = $getModel2['info']['shipmethod'] == 'post' ? 1 : 2;
                            $register->emergency_name = isset($getModel2['info']['emer_person']) ? $getModel2['info']['emer_person'] : '';
                            $register->emergency_phone = isset($getModel2['info']['emer_contact']) ? $getModel2['info']['emer_contact'] : '';
                            $register->type_register = isset($getModel2['info']['type']) ? $getModel2['info']['type'] : ''; // ประเภท
                            $register->type_run = isset($getModel2['info']['distance']) ? $getModel2['info']['distance'] : '';
                            $register->size_shirts = isset($getModel2['info']['size']) ? $getModel2['info']['size'] : '';
                            $register->club = isset($getModel2['info']['team']) ? $getModel2['info']['team'] : '';
//                            $register->club = $getModel2['info']['team'];

                            //ที่อยู่
                            if ($getModel2['info']['shipmethod'] == 'post') {
                                $register->address = isset($getModel2['address']['address']) ? $getModel2['address']['address'] : '';
                                $register->house_no = isset($getModel2['address']['moo']) ? $getModel2['address']['moo'] : '';
                                $register->soi = isset($getModel2['address']['soi']) ? $getModel2['address']['soi'] : '';
                                $register->street = isset($getModel2['address']['street']) ? $getModel2['address']['street'] : '';
                                $register->district = isset($getModel2['address']['subDistrict']) ? $getModel2['address']['subDistrict'] : '';
                                $register->amphoe = isset($getModel2['address']['district']) ? $getModel2['address']['district'] : '';
                                $register->province = isset($getModel2['address']['province']) ? $getModel2['address']['province'] : '';
                                $register->zipcode = $getModel2['address']['zipcode'];
                            }
                            $register->type_group = 1; //สมัครเดี่ยว
                            $register->status = 0; //register
                            //แนบส่ง
                            $register->slip = isset($getModel2['payment']['url']) ? $getModel2['payment']['url'] : '';
                            $register->send_price = isset($getModel2['payment']['fee']) ? $getModel2['payment']['fee'] : '';
                            $register->amount_price = isset($getModel2['payment']['amount']) ? $getModel2['payment']['amount'] : '';
                            $register->save();
                        }
                        if (!empty($register->errors)) {
                            $response = [
                                "status" => 'not',
                                "data" => [],
                            ];
                        } else {
                            $response = [
                                "status" => 'success',
                                "data" => $array1,
                            ];
                        }
                        return $response;
                    }
                }
            } else {
                return $response = [
                    "status" => 'not',
                    "data" => [],
                ];
            }
        }
        return $response = [
            "status" => 'not',
            'text' => 'end',
            "data" => [],
        ];
    }

    public function actionIdCard()
    {
        function checkNumberCard($id_card)
        {
            if (strlen($id_card) != 13) {
                return false;
            }
            for ($i = 0, $sum = 0; $i < 12; $i++) {
                $sum += (int)($id_card{$i}) * (13 - $i);
            }

            if ((11 - ($sum % 11)) % 10 == (int)($id_card{12})) {
                return true;
            }
            return false;
        }

        if ($dataPost = Yii::$app->request->rawBody) {
            $dataJsonPost = json_decode($dataPost, true);
            $data = strval($dataJsonPost['citizen']);
            if (isset($data) && strlen($data) == 13 && is_numeric($data)) {
                if (checkNumberCard($data)) {
                    $rg = Register::findOne(['id_card' => $data]);
                    if (!empty($rg)) {
                        return $response = [
                            "status" => 'success',
                            'existing' => true,
                        ];
                    } else {
                        return $response = [
                            "status" => 'success',
                            'existing' => false,
                        ];
                    }
                } else {
                    return $response = [
                        "status" => 'false',
                        "data" => 'รหัสบัตรไม่ถูกต้อง !',
                    ];
                }

            } else {
                return $response = [
                    "status" => 'false',
                    "data" => [],
                ];
            }
        } else {
            return $response = [
                "status" => 'false',
                "data" => [],
            ];
        }

    }
}
