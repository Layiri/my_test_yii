<?php

use app\models\ListsTasks;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Tasks */

$this->title = 'Create Tasks';
$this->params['breadcrumbs'][] = ['label' => 'Tasks', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tasks-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'modelsListTask' => (empty($modelsListTask)) ? [new ListsTasks] : $modelsListTask

    ]) ?>

</div>
