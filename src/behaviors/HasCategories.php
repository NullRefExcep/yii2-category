<?php

namespace nullref\category\behaviors;

use nullref\category\models\Category;
use nullref\core\behaviors\HasManyRelation;
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
class HasCategories extends HasManyRelation
{
    public $entityModuleId = 'category';
    public $entityManagerName = 'categoryManager';
    public $attributeName = 'categories';
    public $fromFieldName = 'categoryId';
    public $toFieldName = 'entityId';
    public $tableName = '{{%entity_has_category}}';

    public function getAttributeName()
    {
        return $this->attributeName;
    }

    public function getFromFieldName()
    {
        return $this->fromFieldName;
    }

    public function getToFieldName()
    {
        return $this->toFieldName;
    }

    public function getAttributeLabel()
    {
        return Yii::t('catalog', 'Category');
    }

    public function getTableName()
    {
        return $this->tableName;
    }
}