<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\TasksObjects */

$this->title = 'Create Tasks Objects';
$this->params['breadcrumbs'][] = ['label' => 'Tasks Objects', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tasks-objects-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
