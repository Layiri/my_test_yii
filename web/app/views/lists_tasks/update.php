<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\ListsTasks */

$this->title = 'Update Lists Tasks: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Lists Tasks', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="lists-tasks-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
