<?php

namespace nullref\category\models;
use yii\db\ActiveQuery;

/**
 * This is the ActiveQuery class for [[Category]].
 *
 * @see Category
 */
class CategoryQuery extends ActiveQuery
{
    /**
     * @inheritdoc
     * @return Category[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Category|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }

    /**
     * @return $this
     */
    public function roots()
    {
        return $this->andWhere(['parent_id' => Category::ROOT_PARENT]);
    }

    /**
     * @param Category $model
     * @return $this
     */
    public function siblings(Category $model)
    {
        return $this->byParent($model->parent_id)->without($model->id);
    }

    /**
     * @param $id
     * @return $this
     */
    public function without($id)
    {
        return $this->andWhere(['not', ['id' => $id]]);
    }

    /**
     * @param $id
     * @return $this
     */
    public function byParent($id)
    {
        return $this->andWhere(['parent_id' => $id]);
    }
}
