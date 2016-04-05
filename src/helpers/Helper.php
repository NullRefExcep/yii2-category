<?php
/**
 * @author    Dmytro Karpovych
 * @copyright 2016 NRE
 */


namespace nullref\category\helpers;


use nullref\category\models\Category as Model;
use yii\helpers\Html;

class Helper
{
    /**
     * @param Model $model
     * @return string
     */
    public static function getCategoryParentsLinks(Model $model)
    {
        $parents = array_map(function (Model $model) {
            return Html::a($model->title, ['view', 'id' => $model->id]);
        }, $model->parents);

        return implode(', ', $parents);
    }
}