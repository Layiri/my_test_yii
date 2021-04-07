<?php

namespace app\controllers;

use app\models\ListsTasks;
use app\models\ModelExtra;
use Yii;
use app\models\Tasks;
use app\models\search\TasksSearch as TasksSearch;
use yii\db\Exception;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * TasksController implements the CRUD actions for Tasks model.
 */
class TasksController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Tasks models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new TasksSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Tasks model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Tasks model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Tasks();
        $modelsListTask = [new ListsTasks];

        if ($model->load(Yii::$app->request->post()) ) {

            $modelsListTask = ModelExtra::createMultiple(ListsTasks::classname());
            ModelExtra::loadMultiple($modelsListTask, Yii::$app->request->post());

            // validate all models
            $valid = $model->validate();
            $valid = ModelExtra::validateMultiple($modelsListTask) && $valid;


            if ($valid) {
                $transaction = \Yii::$app->db->beginTransaction();

                try {
                    if ($flag = $model->save(false)) {
                        foreach ($modelsListTask as $task) {
                            $task->task_id = $model->id;
                            if (! ($flag = $task->save(false))) {
                                $transaction->rollBack();
                                break;
                            }
                        }
                    }
                    if ($flag) {
                        $transaction->commit();
                        return $this->redirect(['view', 'id' => $model->id]);
                    }
                } catch (Exception $e) {
                    $transaction->rollBack();
                }
            }
        }

        return $this->render('create', [
            'model' => $model,
            'modelsListTask' => (empty($modelsListTask)) ? [new ListsTasks] : $modelsListTask
        ]);
    }

    /**
     * Updates an existing Tasks model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $modelsListTask = $model->listTasks;

        if ($model->load(Yii::$app->request->post()) ) {

            $oldIDs = ArrayHelper::map($modelsListTask, 'id', 'id');
            $modelsListTask = ModelExtra::createMultiple(ListsTasks::classname(), $modelsListTask);
            ModelExtra::loadMultiple($modelsListTask, Yii::$app->request->post());
            $deletedIDs = array_diff($oldIDs, array_filter(ArrayHelper::map($modelsListTask, 'id', 'id')));

            // validate all models
            $valid = $model->validate();
            $valid = ModelExtra::validateMultiple($modelsListTask) && $valid;

            if ($valid) {
                $transaction = \Yii::$app->db->beginTransaction();
                try {
                    if ($flag = $model->save(false)) {
                        if (!empty($deletedIDs)) {
                            ListsTasks::deleteAll(['id' => $deletedIDs]);
                        }
                        foreach ($modelsListTask as $task) {
                            $task->task_id = $model->id;
                            if (! ($flag = $task->save(false))) {
                                $transaction->rollBack();
                                break;
                            }
                        }
                    }
                    if ($flag) {
                        $transaction->commit();
                        return $this->redirect(['view', 'id' => $model->id]);
                    }
                } catch (Exception $e) {
                    $transaction->rollBack();
                }
            }

        }

        return $this->render('update', [
            'model' => $model,
            'modelsListTask' => (empty($modelsListTask)) ? [new ListsTasks] : $modelsListTask
        ]);
    }

    /**
     * Deletes an existing Tasks model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Tasks model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Tasks the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Tasks::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
