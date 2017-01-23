<?php
namespace usesgraphcrt\certificate\behaviors;

use yii;
use yii\base\Behavior;

class Certification extends Behavior
{
    public $certificatePaymentTypes = null;

    public function events()
    {
        return [
            'create' => 'useCertificate'
        ];
    }
    public function useCertificate($event)
    {

        $orderModel = $event->model;
        $orderElements = $event->elements;
        $targetModelList = yii::$app->certificate->getTargetModels();
        if (yii::$app->certificate->getCode()) {
            $certificate = yii::$app->certificate->getCurrent();
            foreach ($orderElements as $orderElement) {
                foreach ($targetModelList as $targetModel) {
                    if ($targetModel->target_id == 0) {
                        $sourceTarget = true;
                    } else {
                        $sourceTarget = $targetModel->target_id == $orderElement->item_id;
                    }
                    if ($targetModel->target_model == $orderElement->getModel()->className() && $sourceTarget) {
                        if  ($certificate->type == 'item') {
                            if ($targetModel->amount < $orderElement->count) {
                                $amount = 0;
                            }
                        } elseif ($targetModel->amount < $orderElement->base_price) {
                            $amount = 0;
                        }
                        if ($certificate->type == 'item') {
                            $balance = $orderElement->count;
                            $amount = $targetModel->amount - $balance;
                            if ($amount < 0) { $amount = 0;}
                        } else {
                            $balance = $orderElement->base_price*$orderElement->count;
                            $amount = $targetModel->amount - $balance;
                            if ($amount < 0) { $amount = 0;}
                        }
                        yii::$app->certificate->setCertificateUse($certificate->id,$balance,$targetModel->id,$orderModel->id);
                        yii::$app->certificate->clear();
                    }
                }
            }
        }
    }
}