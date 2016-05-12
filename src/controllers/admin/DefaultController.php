<?php

namespace nullref\category\controllers\admin;

use Yii;
use nullref\category\models\Category;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use nullref\core\interfaces\IAdminController;
use yii\web\Response;

/**
 * CategoryController implements the CRUD actions for Category model.
 */
class DefaultController extends Controller implements IAdminController
{
    /**
     * @var string
     */
    public $modelClass;

    /**
     * @return array
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
     *
     */
    public function init()
    {
        parent::init();
        if ($this->modelClass === null) {
            $this->modelClass = Category::className();
        }
    }


    /**
     * @param int $id
     * @return string
     */
    public function actionIndex($id = 0)
    {
        $categories = call_user_func([$this->modelClass, 'getTree']);
        /** @var Category $model */
        $model = Yii::createObject($this->modelClass);
        $formName = $model->formName();
        return $this->render('index', [
            'categories' => $categories,
            'id' => $id,
            'formName' => $formName,
        ]);
    }

    /**
     * Creates a new Category model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @param bool $parent_id
     * @return string|\yii\web\Response
     */
    public function actionCreate($parent_id = Category::ROOT_PARENT)
    {
        /** @var Category $model */
        $model = Yii::createObject($this->modelClass);

        $model->parent_id = $parent_id;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index', 'id' => $model->parent ? $model->parent->id : 0]);
        }
        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Category model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            if (Yii::$app->request->isAjax) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                return [
                    'success' => !$model->hasErrors(),
                    'errors' => $model->getFirstErrors(),
                ];
            }
            return $this->redirect(['index', 'id' => $model->parent ? $model->parent->id : 0]);
        }

        if (Yii::$app->request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return [
                'model' => $model,
            ];
        }
        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Finds the Category model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Category the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = call_user_func([$this->modelClass, 'findOne'], [$id])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /**
     * Deletes an existing Category model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        /** @var Category $model */
        $model = $this->findModel($id);

        $model->delete();

        return $this->redirect(['index', 'id' => $model->parent ? $model->parent->id : 0]);
    }
}
