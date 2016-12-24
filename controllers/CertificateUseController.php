<?php
namespace usesgraphcrt\certificate\controllers;

use yii;
use yii\web\Controller;
use yii\filters\AccessControl;
use yii\web\NotFoundHttpException;
use yii\helpers\Html;
use yii\filters\VerbFilter;
use pistol88\cart\widgets\CartInformer;

class CertificateUseController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
            ],
        ];
    }

    public function actionEnter()
    {
        try {
            $certificate = yii::$app->request->post('certificate');

            if(yii::$app->request->post('clear')) {
                yii::$app->certificate->clear();
                $persent = false;
                $message = 'Сертификат удален!';
            } else {
                yii::$app->certificate->enter($certificate);
                //$persent = yii::$app->certificate->get()->certificate->discount;
                $message = 'Будет использован сертификат';
            }

            if(yii::$app->cart) {
                $newCost = yii::$app->cart->costFormatted;
            }
            else {
                $newCost = null;
            }

            return json_encode([
                'code' => Html::encode($certificate),
                'informer' => CartInformer::widget(),
                'result' => 'success',
                'newCost' => $newCost,
                'message' => $message
            ]);
        }
        catch(\Exception $e) {
            return json_encode(['informer' => CartInformer::widget(), 'result' => 'fail', 'message' => $e->getMessage()]);
        }
    }
}
