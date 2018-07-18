<?php

namespace ext\modules\runner\controllers;


use ext\modules\runner\models\Register;
use ext\modules\runner\models\RegisterSearch;
use Yii;
use yii\data\ActiveDataProvider;
use yii\data\ArrayDataProvider;
use yii\filters\AccessControl;
use yii\helpers\Json;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use Mpdf\Mpdf;

/**
 * RegisterController implements the CRUD actions for Register model.
 */
class RegisterController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout','search-user','index','post-sum-day'],
                'rules' => [
                    [
                        'actions' => ['login', 'error'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout','search-user','index','post-sum-day'],
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
        $searchModel = new RegisterSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }


    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }


    public function actionCreate()
    {
        $model = new Register();
        $modelDetail = new  RegisterDetails();
        if ($model->load(Yii::$app->request->post())) {
            $model->status = 0;
            $model->save();
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Register model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
        \Yii::$app
            ->db
            ->createCommand()
            ->delete('register', ['register_id' => $id])
            ->execute();
        return $this->redirect(['index']);
    }


    protected function findModel($id)
    {
        if (($model = Register::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionPostSumDay()
    {
        $dataProvider = Yii::$app->db->createCommand("SELECT DATE (created_at) AS date_send,COUNT (ID) FROM register WHERE register_id IS NULL AND delivery_status=1 AND send_status IS NULL and status =1 GROUP BY date_send 	ORDER BY date_send DESC")->queryAll();
        return $this->render('post-sum-day', [
            'dataProvider' => $dataProvider
        ]);
    }
    public function actionDetailsAll($id)
    {
        $dataProvider = Yii::$app->db->createCommand("SELECT DATE ( created_at ) AS date_send,
	CONCAT(firstname, ' ', lastname) AS fullname,send_status,id,address,
	house_no,soi,street,district,amphoe,province,zipcode,phone
FROM register 
WHERE
	register_id IS NULL 
	AND delivery_status = 1
	AND send_status IS NULL 
	AND  DATE ( created_at ) = :id")->bindValues(['id' => $id])->queryAll();
        return $this->render('details-all', [
            'dataProvider' => $dataProvider
        ]);
    }

    public function actionSendPrint($id)
    {
        $dataProvider = Yii::$app->db->createCommand("SELECT DATE
	( created_at ) AS date_send,
	CONCAT(firstname, ' ', lastname) AS fullname,
	send_status,
	id,
	address,
	house_no,
	soi,
	street,
	district,
	amphoe,
	province,
	zipcode,
	phone
FROM
	register 
WHERE
	register_id IS NULL 
	AND delivery_status = 1 
	AND send_status IS NULL 
	AND  DATE ( created_at ) = :id")->bindValues(['id' => $id])->queryAll();
//
//    return $this->renderPartial('_send-print',[
//            'dataProvider'=>$dataProvider
//        ]);
        $html = $this->renderPartial('_send-print', [
            'dataProvider' => $dataProvider
        ]);
        $mpdf = new Mpdf([
            'mode' => 'UTF-8',
            'format' => 'A4',
            'orientation' => 'L',
            'margin_top' => '0',
            'margin_left' => '0',
            'margin_right' => '0',
            'margin_bottom' => '0',
        ]);
        $mpdf->WriteHTML($html);
        $mpdf->Output();

    }

    public function actionSaveSend()
    {
        if ($data = \Yii::$app->request->post('id')) {
            foreach ($data as $model) {
                $rg = Register::findOne(['id' => $model]);
                $rg->send_status = 1;
                $rg->save();
            }
            return $this->redirect(['post-sum-day']);
        }
    }

    public function actionSearchUser()
    {
        return $this->render('search-user');
    }
    public function actionSaveData($id)
    {
        $rg=Register::findOne(['id'=>$id]);
        $rg->status = 6 ;
        $rg->save();
        return $this->redirect(['register/search-user']);
    }


    /*  =======================API */
    public function actionApiGetData()
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $dataJson = Register::find()->where(['delivery_status' => 2])->andWhere(['status'=>[1,6]])->orderBy('status asc')->all();
        return $dataJson;
    }
    public function actionGetDetails($id)
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $dataJson = Register::find()->where(['register_id' => $id])->all();
        return $dataJson;
    }
    public function actionGetDataShirts($id)
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $dataJson = Yii::$app->db->createCommand("SELECT size_shirts,COUNT (size_shirts) AS sum_size FROM register WHERE register_id=:register_id OR ID=:id GROUP BY size_shirts")->bindValues(['register_id' => $id, 'id' => $id])->queryAll();
        return $dataJson;
    }
    public function actionReportAll()
    {
        return $this->render('report-all');
    }
    public function actionUpdateRegister()
    {
        if($post=Yii::$app->request->post('data')){
//            $dataArray=Json::decode($post);
           $rg= Register::findOne(['id'=>intval($post['id'])]);
           $rg->type_register = $post["type_register"];
            $rg->type_run = $post["type_run"];
            $rg->size_shirts= $post["size_shirts"];
            if($rg->save()){
                echo  'success';
            }
        }
    }
//    public function actionReset()
//    {
//        return $this->render('reset');
//    }
//    public function actionDelAll()
//    {
//        $del=\Yii::$app
//            ->db
//            ->createCommand()
//            ->delete('register')
//            ->execute();
//        Yii::$app->session->setFlash('success','Clear DataTable Success !');
//        return $this->redirect(['register/reset']);
//    }
}
