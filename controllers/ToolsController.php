<?php
namespace usesgraphcrt\certificate\controllers;

use yii;
use yii\web\Controller;
use yii\filters\AccessControl;

class ToolsController  extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['model-window'],
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => $this->module->adminRoles,
                    ]
                ]
            ],
        ];
    }

    public function actionModelWindow($targetModel = null)
    {
        $this->layout = '@vendor/usesgraphcrt/yii2-certificate/views/layouts/mini';

        $targetSearchModel = $this->module->targetModelList[$targetModel]['searchModel'];
        $targetSimpleModel = $this->module->targetModelList[$targetModel]['model'];
        $searchModel = new $targetSearchModel;
        $model = new $targetSimpleModel;

        $dataProvider = $searchModel->search(yii::$app->request->queryParams);

        return $this->renderAjax('model-window', [
            'searchModel' => $searchModel,
            'model' => $model,
            'dataProvider' => $dataProvider,
            'targetModel' => $targetSimpleModel,
            'targetModelTitle' => $targetModel,
        ]);
    }
}