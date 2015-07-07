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

    public function init()
    {
        parent::init();

        $config = $this->getComponents();
        if (isset($config['categoryManager'])) {
            $config = $config['categoryManager'];
        } else {
            $config = [];
        }
        $config = EntityManager::getConfig('nullref\\category\\models\\', 'Category', $config);
        $this->setComponents([
            'categoryManager' => $config
        ]);
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