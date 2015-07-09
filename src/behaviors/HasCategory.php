<?php

namespace nullref\category\behaviors;

use nullref\category\models\Category;
use nullref\core\behaviors\HasOneRelation;
use Yii;
use yii\db\ActiveRecord;

/**
 * Behavior which provide connection with category
 * @author    Dmytro Karpovych
 *
 * @package nullref\category\behaviors
 *
 * @property ActiveRecord $owner
 * @property Category $category
 */
class HasCategory extends HasOneRelation
{
    public $entityModuleId = 'category';
    public $relationName = 'category';
    public $entityManagerName = 'categoryManager';
    public $attributeName = 'categoryId';
    public $fieldName = 'categoryId';

    public function getAttributeLabel()
    {
        return Yii::t('catalog', 'Category');
    }

    public function getCategory()
    {
        return $this->getRelation();
    }
}