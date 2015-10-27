<?php

namespace nullref\category\models;

use nullref\core\behaviors\SoftDelete;
use nullref\core\models\Model as BaseModel;
use nullref\useful\DropDownTrait;
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
    use DropDownTrait;

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
            'soft-delete' => [
                'class' => SoftDelete::className(),
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
        return parent::find()->where(['deletedAt' => null]);
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
                $result[] = $parents;
            }
        }
        return $result;
    }
}
