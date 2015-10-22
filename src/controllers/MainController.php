<?php

namespace nullref\category\controllers;

use nullref\category\models\Category;
use yii\web\Controller;

/**
 * @author    Dmytro Karpovych
 * @copyright 2015 NRE
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class MainController extends Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionView($id)
    {
        $model = Category::findOne($id);
        return $this->render('create', ['model' => $model]);
    }
} 