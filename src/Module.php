<?php

namespace nullref\category;

use nullref\category\models\ICategory;
use nullref\core\interfaces\IAdminModule;
use Yii;
use yii\base\Module as BaseModule;

/**
 * @author    Dmytro Karpovych
 * @copyright 2015 NRE
 */
class Module extends BaseModule implements IAdminModule
{
    public $controllerNamespace = 'nullref\category\controllers';

    public $categoryModelClass = 'nullref\\category\\models\\Category';
    public $categoryQueryClass = 'nullref\\category\\models\\CategoryQuery';

    public static function getAdminMenu()
    {
        return [
            'label' => Yii::t('category', 'Categories'),
            'url' => ['/category/admin'],
            'icon' => 'archive',
        ];
    }

    /**
     * @return ICategory
     * @throws \yii\base\InvalidConfigException
     */
    public function createCategoryModel()
    {
        return \Yii::createObject($this->categoryModelClass);
    }
} 