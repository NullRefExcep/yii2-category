<?php

namespace nullref\category\controllers;

use nullref\admin\components\AdminController as BaseController;
use nullref\product\Module;

/**
 * @author    Dmytro Karpovych
 * @copyright 2015 NRE
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class AdminController extends BaseController
{
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionCreate()
    {
        /** @var Module $module */
        $module = \Yii::$app->getModule('product');
        $model = $module->createProductModel();
        return $this->render('create', ['model' => $model]);
    }
} 