<?php

use yii\helpers\Html;

$this->title = 'Редактирование сертификата: ' . $model->code;
$this->params['breadcrumbs'][] = ['label' => 'Сертификаты', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Редактирование';
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
