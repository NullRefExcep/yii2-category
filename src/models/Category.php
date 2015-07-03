<?php

namespace nullref\category\models;

use nullref\category\Module;
use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%category}}".
 *
 * @property integer $id
 * @property string $title
 * @property integer $parentId
 * @property integer $type
 * @property string $image
 * @property string $description
 * @property integer $status
 * @property integer $createdAt
 * @property integer $updatedAt
 */
class Category extends ActiveRecord implements ICategory
{
    public function getId()
    {
        return $this->id;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function getType()
    {
        return $this->type;
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%category}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['parentId', 'type', 'status', 'createdAt', 'updatedAt'], 'integer'],
            [['description'], 'string'],
            [['price'], 'number'],
            [['createdAt', 'updatedAt'], 'required'],
            [['title', 'image'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('category', 'ID'),
            'title' => Yii::t('category', 'Title'),
            'parentId' => Yii::t('category', 'Parent ID'),
            'type' => Yii::t('category', 'Type'),
            'image' => Yii::t('category', 'Image'),
            'description' => Yii::t('category', 'Description'),
            'price' => Yii::t('category', 'Price'),
            'status' => Yii::t('category', 'Status'),
            'createdAt' => Yii::t('category', 'Created At'),
            'updatedAt' => Yii::t('category', 'Updated At'),
        ];
    }

    /**
     * @inheritdoc
     * @return CategoryQuery the active query used by this AR class.
     */
    public static function find()
    {
        /** @var Module $module */
        $module = Yii::$app->getModule('category');
        $className = $module->categoryQueryClass;
        return new $className(get_called_class());
    }
}
