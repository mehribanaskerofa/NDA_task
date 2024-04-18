<?php

namespace app\controllers;

use app\services\TodoUpdaterService;
use app\models\Todo;
use app\models\TodoSearch;
use yii\base\InvalidConfigException;
use yii\db\StaleObjectException;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Request;
use yii\web\Response;


class TodoController extends Controller
{
    /**
     * @return array
     */
    public function behaviors(): array
    {
        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }
   /**
     * @var TodoUpdaterService The service responsible for updating Todo models.
     */
    private $todoUpdaterService;

    /**
     * Constructor to inject dependencies.
     *
     * @param string $id
     * @param \yii\base\Module $module
     * @param TodoUpdaterService $todoUpdaterService
     * @param array $config
     */
    public function __construct($id, $module, TodoUpdaterService $todoUpdaterService, $config = [])
    {
        // Inject the TodoUpdaterService into the controller.
        $this->todoUpdaterService = $todoUpdaterService;
        parent::__construct($id, $module, $config);
    }
    /**
     * @return string
     * @throws InvalidConfigException
     */
    public function actionIndex(): string
    {
        /** @var Request $request */
        $request = $this->request;
        $queryParams = $request->getQueryParams();

        $model = \Yii::createObject(TodoSearch::class);
        $dataProvider = $model->search($queryParams);

        return $this->render('index', [
            'searchModel' => $model,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * @param int $id
     *
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionView(int $id): string
    {
        return $this->render('view', [
            'model' => $this->getModel($id),
        ]);
    }

    /**
     * @return string|Response
     * @throws InvalidConfigException
     */
    public function actionCreate()
    {
        /** @var Request $request */
        $request = $this->request;

        $model = \Yii::createObject(TodoSearch::class);
        $model->loadDefaultValues();

        if ($model->load($request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

        /**
     * Action to update a Todo model.
     *
     * @param int $id The ID of the Todo model to update.
     * @return string|\yii\web\Response The rendered view or a redirection response.
     */
    public function actionUpdate(int $id)
    {
        // Get the Todo model by ID.
        $model = $this->getModel($id);

        /** @var Request $request */
        $request = $this->request;

        // Check if the model is successfully loaded with the POST data.
        if ($model->load($request->post())) {
            // Attempt to check and update the Todo model using the service.
            if ($this->todoUpdaterService->checkAndUpdateTodo($model)) {
                // Redirect to the view page if the update is successful.
                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                // Handle conflict if the update fails due to version mismatch.
                Yii::$app->session->setFlash('conflict', 'Conflict: The item has been modified by another user. Please refresh and try again.');
            }
        }

        // Render the update view with the Todo model.
        return $this->render('update', [
            'model' => $model,
        ]);
    }


   

    /**
     * @param int $id
     *
     * @return Response
     * @throws NotFoundHttpException
     * @throws StaleObjectException
     * @throws \Exception
     * @throws \Throwable
     */
    public function actionDelete(int $id): Response
    {
        $model = $this->getModel($id);
        $model->delete();

        return $this->redirect(['index']);
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
