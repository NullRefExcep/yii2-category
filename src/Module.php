<?php

namespace nullref\category;

use nullref\core\interfaces\IAdminModule;
use nullref\core\interfaces\IHasMigrateNamespace;
use Yii;
use yii\base\Application;
use yii\base\BootstrapInterface;
use yii\base\Module as BaseModule;
use yii\i18n\PhpMessageSource;
use yii\web\Application as WebApplication;

/**
 * Class Module
 *
 * @package nullref\category
 */
class Module extends BaseModule implements IAdminModule, BootstrapInterface, IHasMigrateNamespace
{
    /**
     * @var array
     */
    public $classMap = [];

    /**
     * @var array
     */
    protected $_classMap = [
        'Category' => 'nullref\category\models\Category',
        'CategoryQuery' => 'nullref\category\models\CategoryQuery',
    ];

    /**
     * Item for admin menu
     * @return array
     */
    public static function getAdminMenu()
    {
        return [
            'label' => Yii::t('category', 'Categories'),
            'icon' => 'tags',
            'url' => ['/category/admin/default'],
            'order' => 2,
        ];
    }

    /**
     * Bootstrap method to be called during application bootstrap stage.
     * @param Application $app the application currently running
     */
    public function bootstrap($app)
    {
        $classMap = array_merge($this->_classMap, $this->classMap);
        foreach (['Category', 'CategoryQuery'] as $item) {
            $className = __NAMESPACE__ . '\models\\' . $item;
            $definition = $classMap[$item];
            Yii::$container->set($className, $definition);
        }

        if ($app instanceof WebApplication) {
            if (!isset($app->i18n->translations['category*'])) {
                $app->i18n->translations['category*'] = [
                    'class' => PhpMessageSource::class,
                    'basePath' => '@nullref/category/messages',
                ];
            }
        }

    }

    /**
     * Return path to folder with migration with namespaces
     *
     * @param $defaults
     * @return array
     */
    public function getMigrationNamespaces($defaults)
    {
        return ['nullref\category\migration_ns'];
    }
}
