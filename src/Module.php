<?php

namespace nullref\category;

use nullref\core\interfaces\IAdminModule;
use Yii;
use yii\base\Module as BaseModule;

/**
 * @author    Dmytro Karpovych
 * @copyright 2015 NRE
 */
class Module extends BaseModule implements IAdminModule
{
    public static function getAdminMenu()
    {
        return [
            'label' => Yii::t('category', 'Category'),
            'url' => ['/category/admin'],
            'icon' => 'archive',
        ];
    }
} 