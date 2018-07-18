<?php

namespace ext\modules\runner\controllers;

use ext\modules\runner\models\Register;
use ext\modules\runner\models\RegisterSearch;
use kartik\mpdf\Pdf;
use Mpdf\Mpdf;
use yii\data\ActiveDataProvider;
use yii\data\ArrayDataProvider;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\grid\GridView;
use yii\helpers\Json;
use yii\web\Controller;
use Yii;

/**
 * Default controller for the `register` module
 */
class DefaultController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'index'],
                'rules' => [
                    [
                        'actions' => ['logout', 'index'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],

                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        $group_run = \Yii::$app->db->createCommand("SELECT type_register,COUNT (type_register) AS sum_type_register FROM register  GROUP BY type_register ")->queryAll();
        $group_shirts = \Yii::$app->db->createCommand("SELECT size_shirts,COUNT (size_shirts) AS sum_size FROM register  GROUP BY size_shirts ORDER BY  size_shirts DESC ")->queryAll();
        foreach ($group_shirts as &$add) {
            if (empty($add['size_shirts'])) {
                $add['size_shirts'] = 'ไม่รับเสื้อ';
            }
        }
        $provider_run = new ArrayDataProvider([
            'allModels' => $group_run,
            'pagination' => [
                'pageSize' => 10,
            ],
            'sort' => [
                'attributes' => [],
            ],
        ]);
        $provider_shirts = new ArrayDataProvider([
            'allModels' => $group_shirts,
            'pagination' => [
                'pageSize' => 10,
            ],
            'sort' => [
                'attributes' => [],
            ],
        ]);
        $provider = new ArrayDataProvider([
            'allModels' => \Yii::$app->db->createCommand("SELECT
concat(firstname,' ',lastname) as full_name,
to_char( created_at, 'DD/mm/YYYY' ) as created 
FROM
	register 
WHERE
	register_id IS NULL 
ORDER BY created_at DESC LIMIT 10 ")->queryAll(),
            'pagination' => [
                'pageSize' => 10,
            ],
            'sort' => [
                'attributes' => ['created'],
            ],
        ]);
        return $this->render('index', [
            'provider' => $provider,
            'provider_run' => $provider_run,
            'provider_shirts' => $provider_shirts
        ]);
    }

    public function actionReceive()
    {
        $searchModel = new RegisterSearch();
        $dataProvider = $searchModel->search(\Yii::$app->request->queryParams);
        $dataProvider->query->andwhere(['delivery_status' => 2])->andWhere(['status' => 1]);
        return $this->render('report-receive', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionPost()
    {
        $searchModel = new RegisterSearch();
        $dataProvider = $searchModel->search(\Yii::$app->request->queryParams);
        $dataProvider->query->andwhere(['delivery_status' => 1])->andWhere(['status' => 1]);
        return $this->render('report-post', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionNotReceive()
    {
        $searchModel = new RegisterSearch();
        $dataProvider = $searchModel->search(\Yii::$app->request->queryParams);
        $dataProvider->query->andwhere(['delivery_status' => 2])->andwhere('status !=6');
        return $this->render('report-not-receive', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionOkReceive()
    {
        $searchModel = new RegisterSearch();
        $dataProvider = $searchModel->search(\Yii::$app->request->queryParams);
        $dataProvider->query->andwhere('delivery_status =2 and status= 6');
        return $this->render('report-ok-receive', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionCheckPremise()
    {
        $searchModel = new RegisterSearch();
        $dataProvider = $searchModel->search(\Yii::$app->request->queryParams);
        $dataProvider->query->andwhere(['status' => 0]);
        return $this->render('check-premise', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

//Send Email
    public function actionSaveCheck($id)
    {
        $r = Register::findOne(['id' => $id]);
        $this->SendEmail($id);
        $r->status = 1;
        $r->save();
        Yii::$app->session->setFlash('success', 'อนุมัติเรียบร้อย !');
        return $this->redirect(['default/check-premise']);

    }

    public function actionNotSend($id)
    {
        $r = Register::findOne(['id' => $id]);
        $r->status = 1;
        $r->save();
        Yii::$app->session->setFlash('info', 'อนุมัติเรียบร้อย (แบบไม่ส่ง email) !');
        return $this->redirect(['default/check-premise']);

    }

    //view  email
    public function actionViewCheck($id)
    {
        return $this->renderPartial('_send-email', [
            'id' => $id
        ]);
    }

    protected function SendEmail($id)
    {
        $Reg = Register::findOne(['id' => $id]);
        if (!empty($Reg->email)) {
            $messages[] = \Yii::$app->mailer->compose()
                ->setFrom([Yii::$app->params['ClientEmail'] => 'srtrunning@srt.ac.th'])
                ->setTo($Reg->email)
                ->setSubject('อนุมัติการสมัครวิ่ง คุณ ' . $Reg->getFullName())
                ->setHtmlBody($this->renderPartial('_send-email', [
                    'id' => $id
                ]));
            $send = Yii::$app->mailer->sendMultiple($messages);
        }
    }

    public function actionCheckMail()
    {
        return $this->renderPartial('_send-email', [
            'id' => 256
        ]);
    }

    public function actionReportDay()
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        //       return $this->render('report-register');
        return Register::find()->all();
    }

    public function actionReportSummary()
    {
        if ($post = Yii::$app->request->post('search-date')) {
            $dateAfter = substr($post, 0, 10);
            $dateBefore = substr($post, 13, 10);
            $valible = [':dateAfter' => $dateAfter, ':dateBefore' => $dateBefore];
            $dataQuery = Yii::$app->db->createCommand("SELECT DATE ( created_at ) AS created_at,
            SUM ( send_price ) AS send_price,
            SUM ( amount_price + send_price ) AS price 
            FROM register WHERE DATE ( created_at ) BETWEEN :dateAfter and  :dateBefore  AND  amount_price is not null
            GROUP BY DATE( created_at )")->bindValues($valible)->queryAll();
        } else {
            $dataQuery = Yii::$app->db->createCommand("SELECT DATE( created_at ) AS created_at,
	SUM ( send_price ) AS send_price,
	SUM ( amount_price + send_price ) AS price 
FROM
	register WHERE  amount_price is not null
GROUP BY
DATE( created_at )")->queryAll();
        }
        $dataProvider = new ArrayDataProvider([
            'allModels' => $dataQuery,
            'sort' => [
                'attributes' => ['send_price', 'price'],
            ],
        ]);
        return $this->render('report-summary', [
            'dataProvider' => $dataProvider
        ]);
    }

    public function actionIdCard()
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
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

        if ($dataPost = Yii::$app->request->post()) {

//            $dataJsonPost = json_decode($dataPost, true);
//            $data = strval($dataJsonPost['citizen']);
//            var_dump($dataPost['citizen']);exit();
            $data = $dataPost['citizen'];
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
    public function actionDeleteTeam()
    {

        $post = Yii::$app->request->post();
        if(isset($post)){
            Register::findOne(['id'=>$post['data']])->delete();
            return $this->redirect(['register/update','id'=>$post['id']]);
        }
        var_dump();

    }

    public function actionSaveAdd()
    {
        if ($post = Yii::$app->request->post()) {
            $posts = Yii::$app->request->post('data');
            $id = Yii::$app->request->post('id');
            $dataArray = json_decode($posts, true);
            if (isset($dataArray)) {
              $birthday= $dataArray['birthday'];
              $cut_brirth = substr($birthday,0,4);
                $year = date("Y")+543;
                $age =  $year - intval($cut_brirth);
                $rg_model = new Register();
                $rg_model->register_id = intval($id);
                $rg_model->firstname = !empty($dataArray['firstname']) ? $dataArray['firstname'] : '';
                $rg_model->lastname = !empty($dataArray['lastname']) ? $dataArray['lastname'] : '';
                $rg_model->birthday = !empty($dataArray['birthday']) ? $dataArray['birthday'] : '';
                $rg_model->sex = !empty($dataArray['sex']) ? $dataArray['sex'] : '';
                $rg_model->age = !empty($age) ? $age : '';
                $rg_model->id_card = !empty($dataArray['id_card']) ? $dataArray['id_card'] : '';
                $rg_model->type_register = !empty($dataArray['type_register']) ? $dataArray['type_register'] : '';
                $rg_model->type_run = !empty($dataArray['type_run']) ? $dataArray['type_run'] : '';
                $rg_model->size_shirts = !empty($dataArray['size_shirts']) ? $dataArray['size_shirts'] : '';
                $rg_model->save();
                return $this->redirect(['register/update','id'=>$id]);

            }
        }
    }

    public function actionSaveTest()
    {
        $data = json_decode(file_get_contents("https://ext.nextschool.io/runner/default/report-day"), true);
        foreach ($data as $model) {
            $rg = new Register();
            $rg->id = !empty(intval($model['id'])) ? intval($model['id']) : '';
            $rg->register_id = !empty(intval($model['register_id'])) ? intval($model['register_id']) : '';
            $rg->firstname = $model['firstname'];
            $rg->lastname = $model['lastname'];
            $rg->sex = $model['sex'];
            $rg->birthday = $model['birthday'];
            $rg->id_card = $model['id_card'];
            $rg->age = $model['age'];
            $rg->phone = $model['phone'];
            $rg->email = $model['email'];
            $rg->club = $model['club'];
            $rg->status = $model['status'];
            $rg->delivery_status = $model['delivery_status'];
            $rg->send_status = $model['send_status'];
            $rg->type_group = $model['type_group'];
            $rg->emergency_name = $model['emergency_name'];
            $rg->emergency_phone = $model['emergency_phone'];
            $rg->type_register = $model['type_register'];
            $rg->type_run = $model['type_run'];
            $rg->size_shirts = $model['size_shirts'];
            $rg->slip = $model['slip'];
            $rg->send_price = $model['send_price'];
            $rg->amount_price = $model['amount_price'];
            $rg->address = $model['address'];
            $rg->house_no = $model['house_no'];
            $rg->soi = $model['soi'];
            $rg->street = $model['street'];
            $rg->district = $model['district'];
            $rg->amphoe = $model['amphoe'];
            $rg->province = $model['province'];
            $rg->zipcode = $model['zipcode'];
            $rg->created_at = $model['created_at'];
            $rg->updated_at = $model['updated_at'];
            $rg->save(false);
        }
        return 'ok';
    }


    public function actionReportPdfOne()
    {

        $model_One = Yii::$app->db->createCommand("SELECT * FROM register WHERE type_group = 1 ORDER BY sex ,firstname ")->queryAll();
        $content = $this->renderPartial('report-pdf-one',[
            'model_One'=>$model_One
        ]);
        $mpdf = new Pdf([
            'mode' => Pdf::MODE_UTF8,
            // A4 paper format
            'format' => Pdf::FORMAT_A4,
            'marginLeft' => 5,
            'marginRight' => 5,
            'marginTop' => 10,
            'marginBottom' => 7,
            'marginHeader' => false,
            'marginFooter' => false,
            // portrait orientation
            'orientation' => Pdf::ORIENT_PORTRAIT,
            // stream to browser inline
            'destination' => Pdf::DEST_BROWSER,
            // your html content input
            'content' => $content,
            // format content from your own css file if needed or use the
            // enhanced bootstrap css built by Krajee for mPDF formatting
           // 'cssFile' => '@frontend/web/css/pdf.css',
            // any css to be embedded if required
            'cssInline' => '
            body {
            font-family: "Garuda";
            font-size:12px;
            }
            ',
            // set mPDF properties on the fly
            'options' => ['title' =>'รายงานชื่อนักวิ่ง'],
            // call mPDF methods on the fly
            'methods' => [
                //'SetHeader'=>[''],
                //'SetFooter'=>['{PAGENO}'],
            ]
        ]);

        // return the pdf output as per the destination setting
        return $mpdf->render();
    }
    public function actionReportPdfTeam()
    {

        $model_team = Yii::$app->db->createCommand("SELECT * FROM register WHERE type_group = 2 ORDER BY sex ,firstname ")->queryAll();
        $content = $this->renderPartial('report-pdf-team',[
            'model_team'=>$model_team
        ]);
        $mpdf = new Pdf([
            'mode' => Pdf::MODE_UTF8,
            // A4 paper format
            'format' => Pdf::FORMAT_A4,
            'marginLeft' => 5,
            'marginRight' => 5,
            'marginTop' => 10,
            'marginBottom' => 7,
            'marginHeader' => false,
            'marginFooter' => false,
            // portrait orientation
            'orientation' => Pdf::ORIENT_PORTRAIT,
            // stream to browser inline
            'destination' => Pdf::DEST_BROWSER,
            // your html content input
            'content' => $content,
            // format content from your own css file if needed or use the
            // enhanced bootstrap css built by Krajee for mPDF formatting
            // 'cssFile' => '@frontend/web/css/pdf.css',
            // any css to be embedded if required
            'cssInline' => '
            body {
            font-family: "Garuda";
            font-size:12px;
            }
            ',
            // set mPDF properties on the fly
            'options' => ['title' =>'รายงานชื่อนักวิ่ง'],
            // call mPDF methods on the fly
            'methods' => [
                //'SetHeader'=>[''],
                //'SetFooter'=>['{PAGENO}'],
            ]
        ]);

        // return the pdf output as per the destination setting
        return $mpdf->render();
    }
    public function actionReportExcelOne()
    {
        $data = Yii::$app->db->createCommand("SELECT * FROM register WHERE type_group = 1 ORDER BY sex ,firstname ")->queryAll();
        $nameFile =time();
        header("Content-Type: application/vnd.ms-excel");
        header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
        header("Cache-Control: max-age=0");
        header('Content-Disposition: attachment; filename="'.$nameFile.'_one'.'.xls"');//ชื่อไฟล์
        header("Cache-Control: private",false);
        return $this->renderPartial('report-excel-one',[
            'data'=>$data,
        ]);
    }
    public function actionReportExcelTeam()
    {
        $data = Yii::$app->db->createCommand("SELECT * FROM register WHERE type_group = 2 ORDER BY sex ,firstname ")->queryAll();
        $nameFile =time();
        header("Content-Type: application/vnd.ms-excel");
        header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
        header("Cache-Control: max-age=0");
        header('Content-Disposition: attachment; filename="'.$nameFile.'_team'.'.xls"');//ชื่อไฟล์
        header("Cache-Control: private",false);
        return $this->renderPartial('report-excel-team',[
            'data'=>$data,
        ]);
    }
}
