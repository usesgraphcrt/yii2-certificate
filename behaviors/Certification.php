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
                        if ($targetModel->target_model != 'pistol88\service\models\Category') {
                            $sourceTarget = $targetModel->target_id == $orderElement->item_id;
                        } else {
                            $sourceTarget = $targetModel->target_id == $orderElement->getModel()->category_id;
                        }
                    }
                    if ($targetModel->target_model == $orderElement->getModel()->className() && $sourceTarget || $targetModel->target_model == 'pistol88\service\models\Category' && $sourceTarget) {
                        
                        if ($targetModel->amount == 0 || yii::$app->certificate->getCertificateItemBalance($targetModel->id) == 0) {
                            break;
                        }
                        if ($certificate->type == 'item') {
                            if (yii::$app->certificate->getCertificateItemBalance($targetModel->id) < $orderElement->count) {
                                $amount = yii::$app->certificate->getCertificateItemBalance($targetModel->id);
                            } else {
                                $amount = $orderElement->count;
                            }
                        } else {
                            if (yii::$app->certificate->getCertificateItemBalance($targetModel->id) < ($orderElement->base_price*$orderElement->count)) {
                                $amount = yii::$app->certificate->getCertificateItemBalance($targetModel->id);
                            } else {
                                $amount = $orderElement->base_price * $orderElement->count;
                            }
                        }
                        
                        if ($amount < 0) {
                            $amount = 0;
                        }

                        yii::$app->certificate->setCertificateUse($certificate->id, $amount, $targetModel->id, $orderModel->id);
                        yii::$app->certificate->clear();

                    }
                }
            }
        }
    }
}