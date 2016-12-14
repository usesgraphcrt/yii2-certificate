<?php

//use yii;
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
            'code',
            [
                'attribute' => 'type',
                'format' => 'raw',
                'value' => function($model) {
                    if ($model->type == 'item') {
                        return 'Количество использований';
                    } else
                        if ($model->type == 'sum') {
                            return 'Сумма';
                        }
                },
            ],
            [
                'attribute' => 'created_at',
                'format' => 'raw',
                'value' => function($model) {
                        return date('d.m.Y H:i',strtotime($model->created_at));
                    },
            ],
            [
                'attribute' => 'date_elapsed',
                'format' => 'raw',
                'value' => function($model) {
                    return date('d.m.Y',strtotime($model->date_elapsed));
                },
            ],
            [
                'attribute' => 'target_user',
                'format' => 'raw',
                'value' => function($model) {
                    $targetUser = \Yii::$app->getModule('certificate')->clientModel;
                    $targetUser = $targetUser::find()->where(['id' => $model->target_user])->one();

                    return $targetUser->name;
                },
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update} {delete}',
            ],
        ],
    ]); ?>
</div>
