<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>

<div class="certificate-enter">

    <?php $form = ActiveForm::begin([
        'action' => ['/certificate/certificate-use/enter'],
        'options' => [
            'data-role' => 'certificate-enter-form',
        ]
    ]); ?>
    <?php if(yii::$app->certificate->getCode()) { ?>
        <p class="certificate-discount">Сертификат применен</p>
    <?php } else { ?>
        <p class="certificate-discount" style="display: none;"></p>
    <?php } ?>
    <div class="input-group">
        <input type="hidden" name="<?= Yii::$app->request->csrfParam; ?>" value="<?= Yii::$app->request->csrfToken; ?>" />
        <?= Html::input('text', 'certificate', yii::$app->certificate->getCode(), [
            'class' => 'form-control',
            'placeholder' => 'Сертификат',
            'data-role' => 'certificate-input',
            'data-payment-type-id' => (yii::$app->certificate->getCode()) ? yii::$app->certificate->paymentTypeId : null
            ])
        ?>
        <span class="input-group-btn">
                <?= Html::submitButton('<i class="glyphicon glyphicon-ok"></i>', ['class' => 'btn btn-success certificate-enter-btn']) ?>
                <?= Html::submitButton('<i class="glyphicon glyphicon-remove"></i>', ['class' => 'btn btn-danger certificate-clear-btn']) ?>
            </span>
    </div>
    <?php ActiveForm::end(); ?>

</div>