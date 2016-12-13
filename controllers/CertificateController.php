<?php

namespace usesgraphcrt\certificate\controllers;

use usesgraphcrt\certificate\models\CertificateCertificateToItem;
use Yii;
use usesgraphcrt\certificate\models\CertificateCertificate;
use usesgraphcrt\certificate\models\search\CertificateCertificateSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

class CertificateController extends Controller
{

    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }
    
    public function actionIndex()
    {
        $searchModel = new CertificateCertificateSearch();
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
        $model = new CertificateCertificate();
        $targetModelList = [];

        if ($this->module->targetModelList) {
            $targetModelList = $this->module->targetModelList;
        }
        $model->owner_id = \Yii::$app->user->id;
        $model->created_at = date('Y-m-d H:i:s');
        if ($model->load(Yii::$app->request->post()) ) {
            $targets = Yii::$app->request->post();
            $model->date_elapsed = date('Y-m-d',strtotime(preg_replace('~\D+~','-',$model->date_elapsed)));
            $model->save();
            if ($targets[targetModels] !== null) {
                $this->saveCertificateToModel($targets[targetModels],$model->id);
            }

            return $this->redirect(['index']);
        }
        else {
            return $this->render('create', [
                'model' => $model,
                'targetModelList' => $targetModelList,
            ]);
        }
    }
    
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $certificateItems = CertificateCertificateToItem::find()->where(['certificate_id' => $id])->all();
        $targetModelList = [];
        $items = [];
        
        if ($this->module->targetModelList) {
            $targetModelList = $this->module->targetModelList;
        }

        foreach ($certificateItems as $certificateItem) {
            $target_model = $certificateItem->target_model;
            $target = $target_model::findOne($certificateItem->target_id);
            $items[] = ['['.$certificateItem->target_model.']['.$target->faq_id.']' =>
                [
                    'name' => $target->faq_title,
                    'model' => $certificateItem->target_model,
                    'model_id' => $certificateItem->target_id,
                    'amount' => $certificateItem->amount,
                ]
            ];
        }

        if ($model->load(Yii::$app->request->post()) && $model->save()) {

            $targets = Yii::$app->request->post();

            $this->saveCertificateToModel($targets[targetModels],$model->id,$certificateItems);
            return $this->redirect(['index']);
        } else {
            return $this->render('update', [
                'model' => $model,
                'targetModelList' => $targetModelList,
                'items' => $items,
            ]);
        }
    }
    
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }
    
    protected function findModel($id)
    {
        if (($model = CertificateCertificate::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    protected function saveCertificateToModel($productModels,$certificateId,$savedItems = null){
        if ($productModels){
            foreach ($productModels as $productModel => $modelItems) {
                foreach ($modelItems as $id => $value) {
                    $model = CertificateCertificateToItem::find()->where([
                        'certificate_id' => $certificateId,
                        'target_model' => $productModel,
                        'target_id' =>$id,
                    ])->one();
                    if (!$model) {
                        $model = new CertificateCertificateToItem();
                        $model->certificate_id = $certificateId;
                        $model->target_model = $productModel;
                        $model->target_id = $id;
                        $model->amount = $value;
                        if ($model->validate() && $model->save()){
                            // do nothing
                        } else var_dump($model->getErrors());
                    }
                } //model instance foreach
            } //model namespace foreach
        } //save CertificateCertificateToItem
    }


    public function actionAjaxDeleteTargetItem()
    {
        $target = Yii::$app->request->post();

        $model = CertificateCertificateToItem::find()->where([
            'certificate_id' => $target['data']['certificateId'],
            'target_model' => $target['data']['targetModel'],
            'target_id' => $target['data']['targetModelId'],
        ])->one();
        if ($model) {
            if ($model->delete()) {
                \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                return [
                    'status' => 'success',
                ];
            }   else return [
                'status' => 'error',
            ];
        } else
            return [
                'status' => 'success',
            ];

    }

}
