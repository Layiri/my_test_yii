<?php

use wbraganca\dynamicform\DynamicFormWidget;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Tasks */
/* @var $form yii\widgets\ActiveForm */

$js = '
jQuery(".dynamicform_wrapper").on("afterInsert", function(e, item) {
    jQuery(".dynamicform_wrapper .panel-title-task").each(function(index) {
        jQuery(this).html("Add new Task: " + (index + 1))
    });
});

jQuery(".dynamicform_wrapper").on("afterDelete", function(e) {
    jQuery(".dynamicform_wrapper .panel-title-task").each(function(index) {
        jQuery(this).html("Add new Task: " + (index + 1))
    });
});
';

$this->registerJs($js);

?>

<div class="tasks-form">

    <?php $form = ActiveForm::begin(['id'=> 'dynamic-form']); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?php DynamicFormWidget::begin([
        'widgetContainer' => 'dynamicform_wrapper', // required: only alphanumeric characters plus "_" [A-Za-z0-9_]
        'widgetBody' => '.container-items', // required: css class selector
        'widgetItem' => '.item', // required: css class
        'limit' => 4, // the maximum times, an element can be cloned (default 999)
        'min' => 0, // 0 or 1 (default 1)
        'insertButton' => '.add-item', // css class
        'deleteButton' => '.remove-item', // css class
        'model' => $modelsListTask[0],
        'formId' => 'dynamic-form',
        'formFields' => [
            'name',
        ],
    ]); ?>
    <div class="panel panel-default">
        <div class="panel-heading">
            <i class="fa fa-envelope"></i> Add Tasks
            <button type="button" class="pull-right add-item btn btn-success btn-xs"><i class="fa fa-plus"></i> Add task</button>
            <div class="clearfix"></div>
        </div>
        <div class="panel-body container-items"><!-- widgetContainer -->
            <?php foreach ($modelsListTask as $index => $modelTask): ?>
                <div class="item panel panel-default"><!-- widgetBody -->
                    <div class="panel-heading">
                        <span class="panel-title-task">Task: <?= ($index + 1) ?></span>
                        <button type="button" class="pull-right remove-item btn btn-danger btn-xs"><i class="fa fa-minus"></i></button>
                        <div class="clearfix"></div>
                    </div>
                    <div class="panel-body">
                        <?php
                        // necessary for update action.
                        if (!$modelTask->isNewRecord) {
                            echo Html::activeHiddenInput($modelTask, "[{$index}]id");
                        }
                        ?>
                        <?= $form->field($modelTask, "[{$index}]name")->textInput(['maxlength' => true]) ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    <?php DynamicFormWidget::end(); ?>


    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
