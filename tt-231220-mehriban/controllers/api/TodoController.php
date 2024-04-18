<?php

namespace app\controllers\api;

use app\models\Todo;
use yii\rest\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Request;
use yii\web\ServerErrorHttpException;

class TodoController extends Controller
{
    /**
     * @param integer $id
     *
     * @return Todo
     * @throws NotFoundHttpException
     * @throws ServerErrorHttpException
     */
    public function actionUpdate(int $id): Todo
    {
        /** @var Request $request */
        $request = $this->request;

        $model = $this->getModel($id);
        $model->setAttribute('done', $request->getBodyParam('done'));

        if ($model->save() === false && !$model->hasErrors()) {
            throw new ServerErrorHttpException('Failed to update the object for unknown reason.');
        }

        return $model;
    }

    /**
     * @param int $id
     *
     * @return Todo
     * @throws NotFoundHttpException
     */
    private function getModel(int $id): Todo
    {
        if (($model = Todo::findOne($id)) === null) {
            throw new NotFoundHttpException('Todo record not found.');
        }

        return $model;
    }
}
