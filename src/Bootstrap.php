<?php
namespace nullref\category;

use nullref\category\models\Category;
use nullref\category\models\CategoryQuery;
use yii\base\Application;
use yii\base\BootstrapInterface;
use yii\base\Event;

/**
 * @author    Dmytro Karpovych
 * @copyright 2015 NRE
 */
class Bootstrap implements BootstrapInterface
{
    /**
     * Bootstrap method to be called during application bootstrap stage.
     * @param Application $app the application currently running
     */
    public function bootstrap($app)
    {
        $module = $app->getModule('category');

        $class = Category::className();

        $definition = $class;

        /** @var Module $module */
        if (($module !== null) && (!empty($module->categoryModel))) {
            $definition = $module->categoryModel;
        }

        \Yii::$container->set($class, $definition);

        $className = is_array($definition) ? $definition['class'] : $definition;

        \Yii::$container->set(CategoryQuery::className(), function () use ($className) {
            return $className::find();
        });

        Event::on(CategoryQuery::className(), CategoryQuery::EVENT_INIT, function (Event $e) use ($class, $className) {
            if ($e->sender->modelClass == $class) {
                $e->sender->modelClass = $className;
            }
        });
    }
}
