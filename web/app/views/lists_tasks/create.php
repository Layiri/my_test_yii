<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\ListsTasks */

$this->title = 'Create Lists Tasks';
$this->params['breadcrumbs'][] = ['label' => 'Lists Tasks', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="lists-tasks-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
