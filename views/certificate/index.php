<?php

//use yii;
use yii\helpers\Html;
use yii\grid\GridView;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
/* @var $this yii\web\View */
/* @var $searchModel app\models\search\CertificateCertificateSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Сертификаты';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="certificate-certificate-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Новый Сертификат', ['create'], ['class' => 'btn btn-success']) ?>
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
                'filter'=> Html::activeDropDownList($searchModel,'type',[
                    "item"=>"Количество использований",
                    "sum"=>"Сумма"
                ],
                [
                    'class' => 'form-control',
                    'prompt' => 'Все'
                ]),
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
                'attribute' => 'employment',
                'format' => 'raw',
                'filter'=> Html::activeDropDownList($searchModel,'employment',[
                    "reusable"=>"Многоразовый",
                    "disposable"=>"Одноразовый"
                ],
                [
                    'class' => 'form-control',
                    'prompt' => 'Все'
                ]),
                'value' => function($model) {
                    if ($model->employment == 'reusable') {
                        return 'Многоразовый';
                    } else
                        if ($model->employment == 'disposable') {
                            return 'Одноразовый';
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
                    if ($model->date_elapsed) {
                        return date('d.m.Y',strtotime($model->date_elapsed));
                    } else {
                        return '<span style="color: green">
                                    <i>беcсрочный</i>    
                                </span>';
                    }

                },
            ],
            [
                'attribute' => 'target_user',
                'format' => 'raw',
                //'filter' => \yii\helpers\ArrayHelper::map($targetUser::find()->all(),'id','name'),
                'filter' => Select2::widget([
                    'name' => 'CertificateCertificateSearch[target_user]',
                    'size' => Select2::MEDIUM,
                    'data'  => ['' => 'Все',ArrayHelper::map($targetUser::find()->all(), 'id', 'name')],
                    ]),
                'contentOptions'=>['style'=>'width: 200px;'],
                'value' => function($model){
                    if  ($model->target_user) {
                        return $model->getTargetUser();
                    } else {
                        return '<span style="color: red;">
                                   <i>не выбран<i> 
                                </span>';
                    }

                },
            ],
            [
                'attribute' => 'status',
                'format' => 'raw',
                'filter' => Html::activeDropDownList($searchModel,'status',[
                    "active"=>"Активен",
                    "empty"=>"Израсходован",
                    "elapsed" => "Срок действия истек",
                    "banned" => "Заблокирован"
                ],
                [
                    'class' => 'form-control',
                    'prompt' => 'Все'
                ]),
                'value' => function($model) {
                    if ($model->status == 'banned') {
                        return 'Заблокирован';
                    }
                    if ($model->status == 'empty') {
                            return 'Израсходован';
                    }
                    if ($model->status == 'elapsed') {
                        return 'Срок действия истек';
                    }
                    if ($model->status == 'active') {
                        return 'Активен';
                    }
                },
            ],
            ['class' => 'yii\grid\ActionColumn', 'template' => '{update} {delete}',  'buttonOptions' => ['class' => 'btn btn-default'], 'options' => ['style' => 'width: 103px;']],
        ],
    ]); ?>
</div>
