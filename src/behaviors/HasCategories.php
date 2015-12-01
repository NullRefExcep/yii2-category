<?php

namespace nullref\category\behaviors;

use nullref\category\models\Category;
use nullref\core\behaviors\HasManyRelation;
use nullref\core\behaviors\ManyHasManyRelation;
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
class HasCategories extends ManyHasManyRelation
{
    public $entityModuleId = 'category';
    public $entityManagerName = 'categoryManager';
    public $attributeName = 'categories';
    public $fromFieldName = 'categoryId';
    public $toFieldName = 'entityId';
    public $tableName = '{{%entity_has_category}}';

    public function getAttributeLabel()
    {
        return Yii::t('category', 'Category');
    }
}