<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\Todo $model */

$this->title = $model->title;
$this->params['breadcrumbs'][] = 'Todo #' . $model->id;
?>

<div class="todo-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'title:ntext',
            'priority',
            [
                'attribute' => 'done',
                'value' => function( $data ) {
                    return $data->done ? 'Yes' : 'No';
                },
            ],
        ],
    ]) ?>

</div>
