<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Todo */

$this->title = 'Update Todo: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Todos', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>

<div class="todo-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php if (Yii::$app->session->hasFlash('conflict')): ?>
        <div class="alert alert-warning">
            <?= Yii::$app->session->getFlash('conflict') ?>
            <?= Html::a('Edit again', ['update', 'id' => $model->id], ['class' => 'btn btn-warning']) ?>
            <?= Html::a('Cancel', ['index'], ['class' => 'btn btn-danger']) ?>
        </div>
    <?php endif; ?>

    <?php $form = ActiveForm::begin(); ?>

    <!-- ... existing form fields ... -->

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
