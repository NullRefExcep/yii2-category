<?php

namespace nullref\category\models;

use nullref\core\components\EntityManager;
use nullref\core\models\Model as BaseModel;
use nullref\useful\JsonBehavior;
use Yii;
use yii\behaviors\SluggableBehavior;
use yii\behaviors\TimestampBehavior;

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
 * @property string|array $data
 * @property integer $order
 *
 * @property Category $parent
 * @property Category[] $parents
 * @property Category[] $children
 */
class Category extends BaseModel implements ICategory
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
            'timestamp' => [
                'class' => TimestampBehavior::className(),
                'createdAtAttribute' => 'createdAt',
                'updatedAtAttribute' => 'updatedAt',
            ],
            'slug' => [
                'class' => SluggableBehavior::className(),
                'attribute' => 'title',
                'slugAttribute' => 'slug',
                'immutable' => true,
            ],
            'json' => [
                'class' => JsonBehavior::className(),
                'fields' => ['data'],
            ],
        ]);
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return array_merge([[['parentId', 'type', 'status', 'order'], 'integer'],
            [['description', 'slug'], 'string'],
            [['data'], 'safe'],
            [['order'], 'default', 'value' => 0],
            [['title'], 'required'],
            [['title', 'image'], 'string', 'max' => 255],
        ], parent::rules());
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return array_merge([
            'id' => Yii::t('category', 'ID'),
            'title' => Yii::t('category', 'Title'),
            'parentId' => Yii::t('category', 'Parent'),
            'type' => Yii::t('category', 'Type'),
            'image' => Yii::t('category', 'Image'),
            'description' => Yii::t('category', 'Description'),
            'status' => Yii::t('category', 'Status'),
            'createdAt' => Yii::t('category', 'Created At'),
            'updatedAt' => Yii::t('category', 'Updated At'),
            'slug' => Yii::t('category', 'Slug'),
            'order' => Yii::t('category', 'Order'),
        ], parent::attributeLabels());
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
