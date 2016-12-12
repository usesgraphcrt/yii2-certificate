<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\search\CertificateCertificateSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Certificate Certificates';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="certificate-certificate-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Certificate Certificate', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'code',
            'type',
            'created_at',
            'date_elapsed',
            // 'status',
            // 'owner_id',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
