<?php

namespace usesgraphcrt\certificate\widgets;

use usesgraphcrt\certificate\models\CertificateUse;

class CertificateWidget extends \yii\base\Widget
{

    public function init()
    {
        parent::init();

        \usesgraphcrt\certificate\assets\WidgetAsset::register($this->getView());
    }

    public function run()
    {
        $model = new CertificateUse;

        return $this->render('enter_form', ['model' => $model]);
    }
    
}