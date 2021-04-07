<?php

use kartik\file\FileInput;
use kartik\select2\Select2;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\models\Objects */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="objects-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?php //= $form->field($model, 'images')->textInput() ?>
    <?php
    echo FileInput::widget([
        'name' => 'file_input',
        'options' => [
            'multiple' => true,
             'accept' => 'image/*',

        ],
        'pluginOptions' => [
            'uploadUrl' => Url::to(['/site/file-upload']),
            'uploadExtraData' => [
                'album_id' => 20,
                'cat_id' => 'Nature'
            ],
            'maxFileCount' => 10
        ]
    ]);
    ?>
    <?php echo '<label class="control-label">Object</label>';
    echo Select2::widget([
        'name' => 'object_id',
        'data' => $dataObjects,
        'options' => [
            'placeholder' => 'Select object ...',
        ],
    ]);
    ?>


    <?php echo '<label class="control-label">Tasks</label>';
    echo Select2::widget([
        'name' => 'task_ids',
        'data' => $dataTasks,
        'options' => [
            'placeholder' => 'Select task ...',
            'multiple' => true
        ],
    ]);
    ?>
    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
