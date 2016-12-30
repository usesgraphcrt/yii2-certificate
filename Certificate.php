<?php

namespace usesgraphcrt\certificate;

use usesgraphcrt\certificate\models\CertificateToItem;
use usesgraphcrt\certificate\models\CertificateUse;
use yii;
use usesgraphcrt\certificate\models\Certificate as CertificateModel;

use yii\base\Component;

class Certificate extends Component
{

    public $certificate = null;
    public $session = null;
    public $tmpVars = [];

    public function init()
    {
        $this->certificate = new CertificateModel;
        $this->session = yii::$app->session;

        parent::init();
    }

    public function enter($certificateCode)
    {
        if (!$this->checkCertificateBalance($certificateCode)) {
            throw new \Exception('Сертификат исчерпан');
        }

        if (!$this->checkCertificateStatus($certificateCode)) {
            if(!$certificateModel = $this->getCertificate($certificateCode)) {
                throw new \Exception('Сертификат не найден');
            }

            if  ($certificateModel->status === 'banned') {
                throw new \Exception('Сертификат заблокирован');
            }

            if ($certificateModel->status === 'empty') {
                throw new \Exception('Сертификат исчерпан');
            }
        } else {
            throw new \Exception('Сертификат истёк');
        }
        $this->tmpVars = [];
        return $this->session->set('certificateCode',$certificateModel->code);
    }

    public function getCode()
    {
        return $this->session->get('certificateCode');
    }

    public function getCertificate($certificateCode)
    {
        $certificate = $this->certificate;

        return $certificate::findOne(['code' => $certificateCode]);
    }

    public function getCurrent()
    {
        $certificateCode = $this->getCode();
        $certificate = $this->certificate;
        if ($certificateCode) {
            return $certificate::findOne(['code' => $certificateCode]);
        } else {
            return false;
        }
    }

    public function checkCertificateBalance($certificateCode)
    {
        $certificate = $this->getCertificate($certificateCode);
        $certificateItems = CertificateToItem::find()->where(['certificate_id' => $certificate->id])->all();
        foreach ($certificateItems as $certificateItem) {
            if ($certificateItem->amount != 0) {
                return true;
            }
        }
        return false;
    }

    public function setElementMinusAmount($elementId,$amount)
    {
        $model = CertificateToItem::findOne($elementId);
        $model->amount = $model->amount - $amount;
        if ($model->update()){
            return true;
        } else {
            return false;
        }
    }

    public function setCertificateUse($certificateId,$amount,$itemId,$orderId)
    {
        $model = new CertificateUse;
        $model->certificate_id = $certificateId;
        $model->date = date('Y-m-d H:i:s');
        $model->amount = $amount;
        $model->item_id = $itemId;
        $model->order_id = $orderId;
        if ($model->validate()) {
            $model->save();
            $this->setElementMinusAmount($itemId,$amount);
            if ($this->getCertificate($this->getCode())->employment == 'disposable') {
                $this->setCertificateStatus($this->getCode(),'empty');
            }
            return true;
        } else {
            return $model->getErrors();
        }
    }

    public function checkCertificateStatus($certificateCode)
    {

        $certificate = $this->getCertificate($certificateCode);

        if (strtotime($certificate->date_elapsed) < strtotime(date('Y:m:d H:m:s'))/* || $certificate->employment == 'disposable'*/) {
                $this->setCertificateStatus($certificate,'elapsed');
            return true;
        } else {
            return false;
        }
    }

    public function setCertificateStatus($certificate,$status)
    {
        $certificate->status = $status;

        return $certificate->update();

    }

    public function getTargetModels()
    {
        if($code = $this->getCurrent()) {
            return $code->targetModels;
        } else {
            return false;
        }
    }
    
    

    public function clear()
    {
        return yii::$app->session->remove('certificateCode');
    }
}