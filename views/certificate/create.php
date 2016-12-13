<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\CertificateCertificate */

$this->title = 'Create Certificate Certificate';
$this->params['breadcrumbs'][] = ['label' => 'Certificate Certificates', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="certificate-certificate-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'targetModelList' => $targetModelList,
    ]) ?>

</div>
