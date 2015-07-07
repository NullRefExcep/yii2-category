<?php

namespace nullref\category\models;

use nullref\core\components\EntityManager;
use Yii;
use yii\behaviors\TimestampBehavior;
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
 *
 * @property Category $parent
 * @property Category[] $parents
 * @property Category[] $children
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
    public function behaviors()
    {
        return array_merge(parent::behaviors(), [
            [
                'class' => TimestampBehavior::className(),
                'createdAtAttribute' => 'createdAt',
                'updatedAtAttribute' => 'updatedAt',
            ],
        ]);
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['parentId', 'type', 'status'], 'integer'],
            [['description'], 'string'],
            [['title'], 'required'],
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
            'parentId' => Yii::t('category', 'Parent'),
            'type' => Yii::t('category', 'Type'),
            'image' => Yii::t('category', 'Image'),
            'description' => Yii::t('category', 'Description'),
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
        /** @var EntityManager $manager */
        $manager = Yii::$app->getModule('category')->get('categoryManager');
        $className = $manager->getQueryClass();
        return new $className(get_called_class());
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getChildren()
    {
        return $this->hasMany(self::className(), ['parentId' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParent()
    {
        return $this->hasOne(self::className(), ['id' => 'parentId']);
    }

    /**
     * @return Category[]
     */
    public function getParents()
    {
        $result = [];
        if ($this->parent !== null) {
            $result[] = $this->parent;
            $parents = $this->parent->parents;
            if (!empty($parents)) {
                $result[] = $this->parents;
            }
        }
        return $result;
    }
}
