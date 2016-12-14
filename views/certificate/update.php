<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\CertificateCertificate */

$this->title = 'Update Certificate Certificate: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Certificate Certificates', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="certificate-certificate-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'targetModelList' => $targetModelList,
        'items' => $items,
        'action' => 'update',
        'clients' => $clients,
    ]) ?>

</div>
