<?php
/**
 * @author    Dmytro Karpovych
 * @copyright 2018 NRE
 */


use nullref\category\models\Category;
use voskobovich\linker\LinkerBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the example model class that connected with category records
 *
 * @property integer $id
 *
 * @property array $categoriesList
 * @property Category[] $categories
 *
 */
class Product extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%product}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['categoriesList'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'manyToMany' => [
                'class' => LinkerBehavior::class,
                'relations' => [
                    'categoriesList' => 'categories'
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'categoriesList' => Yii::t('app', 'Categories list'),
        ];
    }

    /**
     * @return ActiveQuery
     */
    public function getCategories()
    {
        return $this->hasMany(Category::class, ['id' => 'category_id'])
            ->viaTable('{{%product_has_category}}', ['product_id' => 'id']);
    }

}
