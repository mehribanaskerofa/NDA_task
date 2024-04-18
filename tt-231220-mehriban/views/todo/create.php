<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Todo $model */

$this->title = 'Create Todo';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="todo-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
