<?php

namespace nullref\category;

use nullref\category\components\EntityManager;
use nullref\core\interfaces\IAdminModule;
use Yii;
use yii\base\Module as BaseModule;

/**
 * @author    Dmytro Karpovych
 * @copyright 2015 NRE
 */
class Module extends BaseModule implements IAdminModule
{
    public $categoryModelClass = 'nullref\\category\\models\\Category';
    public $categoryQueryClass = 'nullref\\category\\models\\CategoryQuery';
    public $categorySearchModelClass = 'nullref\\category\\models\\SearchCategory';

    public function init()
    {
        parent::init();
        if (null === $this->get('categoryManager')) {
            $this->setComponents(['categoryManager' => [
                'class' => EntityManager::className(),
                'modelClass' => $this->categoryModelClass,
                'queryClass' => $this->categoryQueryClass,
                'searchModelClass' => $this->categorySearchModelClass,
            ]]);
        }
    }


    public static function getAdminMenu()
    {
        return [
            'label' => Yii::t('category', 'Categories'),
            'url' => ['/category/admin'],
            'icon' => 'archive',
        ];
    }
} 