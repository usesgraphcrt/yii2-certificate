<?php
namespace usesgraphcrt\certificate\widgets;

use yii\helpers\Html;
use usesgraphcrt\certificate\models\Certificate;
use yii;

class addNewCertificate extends \yii\base\Widget
{

    public function init()
    {
        parent::init();

        \usesgraphcrt\certificate\assets\AddNewAsset::register($this->getView());
    }

    public function run()
    {
        $model = new Certificate;
        $targetModelList = [];

        $clients = yii::$app->getModule('certificate')->clientModel;
        $clients = $clients::find()->all();

        if (yii::$app->getModule('certificate')->targetModelList) {
            $targetModelList = yii::$app->getModule('certificate')->targetModelList;
        }

        $view = $this->getView();
        $view->on($view::EVENT_END_BODY, function($event) use ($model,$targetModelList,$clients) {
            echo $this->render('add_new_form', [
                'model' => $model,
                'targetModelList' => $targetModelList,
                'clients' => $clients,
            ]);

            echo $this->render('_emptyModal');


        });
        

        return Html::a('<span class="glyphicon glyphicon-plus"></span>', '#certificateCreate', ['title' => 'Добавить сертификат', 'data-toggle' => 'modal', 'data-target' => '#certificateCreate', 'class' => 'btn btn-success']);
    }
}