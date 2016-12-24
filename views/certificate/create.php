<?php

use yii\helpers\Html;
use usesgraphcrt\certificate\assets\Asset;


Asset::register($this);

$this->title = 'Новый сертификат';
$this->params['breadcrumbs'][] = ['label' => 'Сертификаты', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="certificate-certificate-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'targetModelList' => $targetModelList,
        'clients' => $clients,
    ]) ?>

</div>
