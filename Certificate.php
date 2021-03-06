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
    public $paymentTypeId = null;

    public function init()
    {
        $this->certificate = new CertificateModel;
        $this->session = yii::$app->session;

        parent::init();
    }

    public function enter($certificateCode)
    {

        if (!$this->getCertificate($certificateCode)) {
            throw new \Exception('Сертификат не найден');
        }

        if (!$this->checkCertificateBalance($certificateCode)) {
            throw new \Exception('Сертификат исчерпан');
        }

        if ($this->checkCertificateStatus($certificateCode)) {

            $certificateModel = $this->getCertificate($certificateCode);

            if ($certificateModel->status === 'banned') {
                throw new \Exception('Сертификат заблокирован');
            }

            if ($certificateModel->status === 'empty') {
                throw new \Exception('Сертификат исчерпан');
            }
        } else {
            throw new \Exception('Сертификат истёк');
        }
        $this->tmpVars = [];
        return $this->session->set('certificateCode', $certificateModel->code);
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
            return $certificate::find()->where(['code' => $certificateCode])->one();
        } else {
            return false;
        }
    }
    
    public function getTargetModels()
    {
        if ($code = $this->getCurrent()) {
            return $code->targetModels;
        } else {
            return false;
        }
    }

    public function getCertificateByOrderId($orderId)
    {

        $certificateUse = CertificateUse::find()->where(['order_id' => $orderId])->one();
        if (!empty($certificateUse)) {
            return CertificateModel::findOne($certificateUse->certificate_id);
        } else {
            return false;
        }


    }

    public function getCertificateCodeByClientId($clientId)
    {
        $certificate = $this->certificate;

        return $certificate::findOne(['target_user' => $clientId])->code;
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

    public function getCertificateUsedSum($orderId)
    {
        return CertificateUse::find()->where(['order_id' => $orderId])->sum('amount');
    }

    public function getCertificateStatus($certificateCode)
    {
        return CertificateModel::find()->where(['code' => $certificateCode])->one()->status;
    }

    public function getCertificateItemBalance($itemId)
    {
        $model = CertificateToItem::findOne($itemId);

        if ($model) {
            return $model->amount;
        }

        return false;
    }
    
    public function setUserToCertificate($userId,$certificateCode)
    {
        $certificate = $this->certificate;
        
        $certificate = $certificate::findOne(['code' => $certificateCode]);
        
        $certificate->target_user = $userId;
        
        return $certificate->save(false);
    }

    public function setElementMinusAmount($elementId, $amount)
    {
        $model = CertificateToItem::findOne($elementId);

        if ($amount > $model->amount) {
            $model->amount = 0;
        } else {
            $model->amount = $model->amount - $amount;
        }

        if ($model->save(false)) {
            return true;
        } else {
            return false;
        }
    }

    public function setCertificateUse($certificateId, $amount, $itemId, $orderId)
    {

        $certificate = CertificateModel::findOne($certificateId);

        $model = new CertificateUse;
        $model->certificate_id = $certificateId;
        $model->date = date('Y-m-d H:i:s');
        $model->amount = $amount;
        $model->item_id = $itemId;
        $model->order_id = $orderId;
        if ($model->validate()) {

            $this->setElementMinusAmount($itemId, $amount);

            $model->balance = $this->getCertificateItemBalance($itemId);

            $model->save();

            if (!$this->checkCertificateBalance($certificate->code)) {
                $this->setCertificateStatus(CertificateModel::findOne($certificateId), 'empty');
            }

            if (CertificateModel::findOne($certificateId)->employment == 'disposable') {
                $this->setCertificateStatus(CertificateModel::findOne($certificateId), 'empty');
            }
            return true;
        } else {
            return $model->getErrors();
        }
    }

    public function setCertificateStatus($certificate, $status)
    {
        $certificate->status = $status;

        return $certificate->save(false);

    }

    public function setCertificateBalance($itemId, $balance)
    {
        $certificateItem = CertificateToItem::find()->where(['id' => $itemId])->one();
        $certificateItem->amount += (int)$balance;

        $certificateItem->save(false);

        $certificate = CertificateModel::findOne($certificateItem->certificate_id);

        if ($this->getCertificateStatus($certificate->code) != 'active') {
            $this->setCertificateStatus($certificate, 'active');
        }

    }

    public function clearCertificateUseHistory($orderId)
    {
        return CertificateUse::deleteAll(['order_id' => $orderId]);
    }

    public function rollbackCertificateUse($orderId)
    {

        $certificateUses = CertificateUse::find()->where(['order_id' => $orderId])->all();
        foreach ($certificateUses as $certificateUse) {
            $this->setCertificateBalance($certificateUse->item_id, $certificateUse->amount);
        }

        $this->clearCertificateUseHistory($orderId);

    }

    public function clear()
    {
        return yii::$app->session->remove('certificateCode');
    }

    public function checkCertificateStatus($certificateCode)
    {

        $certificate = $this->getCertificate($certificateCode);

        if (empty($certificate->date_elapsed)) {
            return true;
        }

        if (strtotime($certificate->date_elapsed) < strtotime(date('Y:m:d H:m:s'))) {
            $this->setCertificateStatus($certificate, 'elapsed');
            return false;
        } else {
            return true;
        }
    }
}