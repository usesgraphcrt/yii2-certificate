<?php

use kartik\grid\GridView;

$this->registerJs("
$(document).on('click','[data-role=add-model]', function() {
        var id = $(this).data('target-model-id');
        var name = $(this).data('target-model-name');
        var targetModel = $(document).find('[data-role=target-model]').val();
        existItem = window.parent.usesgraphcrt.certificate.getTargetItem(id,targetModel);
        if (existItem) {
            alert('Элемент уже добавлен!');
        } else {
            window.parent.usesgraphcrt.certificate.updateModelList(id,targetModel,name);
            $('.product-modal').modal('toggle');
        }
    });");
?>
<div class="product-window">
    <div class="row">
        <div class="col-sm-12">
            <input type="hidden" value="<?=$targetModel?>" data-role="target-model">
            <div class="btn btn-primary pull-right" data-role="add-model" data-target-model-id="0" data-target-model-name="<?= $targetModelTitle ?>">На всю группу</div>
            <br>
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
                    [
                        'attribute' => 'name',
                        'content' => function($model) {
                            return $model->name;
                        }
                    ],
                    [
                        'format' => 'raw',
                        'content' => function ($model) {
                            return '<div class="btn btn-default" 
                        data-role="add-model"
                        data-target-model-name="'.$model->name.'"
                        data-target-model-id="'.$model->id.'">
                        Добавить</div>';
                        }
                    ]
                ],
                'pjax' => true,
            ]); ?>
        </div>
    </div>
</div>