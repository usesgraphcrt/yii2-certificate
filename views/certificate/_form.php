<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\date\DatePicker;
use yii\bootstrap\Modal;
use usesgraphcrt\certificate\assets\Asset;

Asset::register($this);

?>

<div class="certificate-certificate-form">
    <div class="container-fluid">
        <?php $form = ActiveForm::begin(); ?>
        <div class="row">
            <div class="col-md-6">
                <?= $form->field($model, 'code')->textInput(['maxlength' => true])->label('Название сертификата') ?>

                <?= $form->field($model, 'type')->dropDownList([
                    'item' => 'Количество использований',
                    'sum' => 'Сумма',
                ],
                    [
                        'prompt' => 'Выберите тип сертификата:'
                    ])->hint('Укажите тип сертификата.')->label('Тип сертификата')
                ?>
                <?= $form->field($model, 'date_elapsed')->widget(DatePicker::classname(), [
                        'language' => 'ru',
                        'type' => DatePicker::TYPE_COMPONENT_PREPEND,
                        'options' => ['placeholder' => 'Дата истечения сертификата'],
                        'removeButton' => false,
                        'pluginOptions' => [
                            'autoclose'=>true,
                            'format' => 'yyyy-m-d',
                        ]
                    ])->label('Дата истечения сертификата')->hint('Выберите дату истечения срока действия сертификата')
                ?>
                <?= $form->field($model, 'status')->dropDownList([
                    'active' => 'Активен',
                    'elapsed' => 'Срок действия стек',
                    'empty' => 'Израсходован',
                    'banned' => 'Заблокирован',
                ],
                    [
                        'prompt' => 'Укажите статус сертиификата:'
                    ])->label('Статус') ?>

                <div class="form-group">
                    <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
                </div>
            </div>
            <div class="col-md-6 certificate-right-column">
                <div class="row">
                    <div class="col-md-4">
                        <?php foreach ($targetModelList as $modelName => $modelType){ ?>
                        <?php
                            Modal::begin([
                               'header' => '<h2>Сертификат для '.$modelName.'</h2>',
                                'size' => 'modal-lg',
                                'toggleButton' => [
                                    'tag' => 'button',
                                    'class' => 'btn btn-sm btn-block btn-primary',
                                    'label' => $modelName . ' <i class="glyphicon glyphicon-plus"></i>',
                                    'data-model' => $modelType['model'],
                                ]
                            ]);
                        ?>
                        <iframe src="/certificate/tools/model-window?targetModel=<?= $modelName ?>" frameborder="0" style="width: 100%; height: 500px;">
                        </iframe>
                        <?php
                        Modal::end();
                        ?>
                    <?php } ?>
                    </div>
                </div>
                <div class="row">
                    <table class="table table-bordered">
                        <tbody data-role="model-list" id="modelList">
                        <tr>
                            <th>Наименование</th>
                            <th>Количество</th>
                            <th>Удаление</th>
                        </tr>
                        <?php
                        if ($items) {
                            foreach ($items as $item) {
                                foreach ($item as $item_id => $item_attr) {
                                    ?>
                                    <tr data-role="item">
                                        <td><label>
                                                <?=$item_attr['name']?>
                                            </label>
<!--                                            <input type="hidden" data-role="product-model" name="targetModels--><?//=$item_id?><!--"-->
<!--                                                   data-name="--><?//= str_replace(['[',']','\\'],"",$item_id)?><!--"/>-->
                                        </td>
                                        <td>
                                            <input type="text" data-role="product-model" name="targetModels<?=$item_id?>"
                                            data-amount="" value="<?=$item_attr['amount']?>">
                                        </td>
                                        <td>
                                            <span data-href="ajax-delete-model-item" class="btn glyphicon glyphicon-remove" style="color: red;" 
                                                  data-role="remove-target-item"
                                                  data-target-model="<?=$item_attr['model'] ?>"
                                                  data-target-model-id="<?=$item_attr['model_id'] ?>"></span>
                                        </td>

                                    </tr>
                                <?php    }
                            }
                        }
                        ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>
