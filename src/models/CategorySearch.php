<?php

namespace nullref\category\models;

use nullref\core\behaviors\HasRelation;
use nullref\core\behaviors\ManyHasManyRelation;
use nullref\core\behaviors\ManyHasOneRelation;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\db\ActiveQuery;

/**
 * SearchCategory represents the model behind the search form about `nullref\category\models\Category`.
 */

/** A little bit of magic */
if (class_exists('\app\models\Category')) {
    class ParentCategorySearch extends \app\models\Category
    {
    }
} elseif (class_exists('\app\modules\category\models\Category')) {
    class ParentCategorySearch extends \app\modules\category\models\Category
    {
    }
} else {
    class ParentCategorySearch extends Category
    {
    }
}

class CategorySearch extends ParentCategorySearch
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        $fields = [];
        foreach ($this->behaviors as $behavior) {
            if ($behavior instanceof HasRelation) {
                $fields[] = $behavior->getAttributeName();
            }
        }
        return array_merge([
            [['id', 'parentId', 'type', 'status', 'createdAt', 'updatedAt'], 'integer'],
            [['title', 'image', 'description'], 'safe'],
        ], [[$fields, 'safe']]);
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params, $class = 'nullref\category\models\Category')
    {
        /** @var ActiveQuery $query */
        $query = $class::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'parentId' => $this->parentId,
            'type' => $this->type,
            'status' => $this->status,
            'createdAt' => $this->createdAt,
            'updatedAt' => $this->updatedAt,
        ]);


        foreach ($this->behaviors as $behavior) {
            if ($behavior instanceof ManyHasOneRelation) {
                $query->andFilterWhere([$behavior->getAttributeName() => $this->{$behavior->getAttributeName()}]);
            }
            if ($behavior instanceof ManyHasManyRelation) {
                $ids = $this->{$behavior->getAttributeName()};
                if (!empty($ids)) {
                    $query->innerJoin($behavior->getTableName(),
                        $behavior->getTableName() . '.' . $behavior->getToFieldName() . ' = ' . $this->tableName() . '.`id`');
                    $query->andWhere([$behavior->getTableName() . '.' . $behavior->getFromFieldName() => $ids]);
                    /**
                     * foreach($ids as $id){
                     * $query->andWhere([$behavior->getTableName() . '.' . $behavior->getFromFieldName() => $id]);
                     * }
                     */
                }
            }
        }
        $query->andWhere(['deleted' => null]);
        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'image', $this->image])
            ->andFilterWhere(['like', 'description', $this->description]);

        return $dataProvider;
    }
}
