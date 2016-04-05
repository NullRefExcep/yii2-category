<?php

namespace nullref\category\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%category_closure}}".
 *
 * @property integer $category_id
 * @property integer $parent_id
 * @property integer $level
 *
 * @property Category $category
 */
class CategoryClosure extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%category_closure}}';
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(Category::className(), ['id' => 'child_id']);
    }
}
