<?php

namespace nullref\category\models;

use Yii;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\db\Expression;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "{{%category}}".
 *
 * @property integer $id
 * @property string $title
 * @property integer $parent_id
 * @property float $sort_order
 *
 * @property integer $depth
 *
 * @property Category|null $parent
 * @property Category[] $parents
 * @property Category[] $descendants
 * @property Category[] $children
 *
 */
class Category extends ActiveRecord
{
    /**
     * @var string
     */
    public $closureClass = 'nullref\category\models\CategoryClosure';

    /**
     * Parent of root nodes
     */
    const ROOT_PARENT = 0;

    /**
     * Using when move node
     * @var integer
     */
    public $beforeId;

    /**
     * Returns all of categories as tree
     *
     * @param array $options
     * @return mixed
     */
    public static function getTree(array $options = [])
    {
        $depth = ArrayHelper::remove($options, 'depth', -1);
        /** @var \Closure $filter */
        $filter = ArrayHelper::remove($options, 'filter', function ($item) {
            return true;
        });

        /** @var Category[] $list */
        $list = self::find()->all();

        $list = ArrayHelper::remove($options, 'list', $list);

        $getChildren = function ($id, $depth) use ($list, &$getChildren, $filter) {
            $result = [];
            foreach ($list as $item) {
                if ((int)$item['parent_id'] === (int)$id) {
                    $r = [
                        'title' => $item['title'],
                        'sort_order' => $item['sort_order'],
                        'id' => $item['id'],
                    ];
                    $c = $depth ? $getChildren($item['id'], $depth - 1) : null;
                    if (!empty($c)) {
                        $r['children'] = $c;
                    }
                    if ($filter($r)) {
                        $result[] = $r;
                    }
                }
            }

            usort($result, function ($a, $b) {
                return $a['sort_order'] > $b['sort_order'];
            });

            return $result;

        };

        return $getChildren(0, $depth);
    }

    /**
     * @inheritdoc
     * @return CategoryQuery the active query used by this AR class.
     */
    public static function find()
    {
        $definitions = Yii::$container->getDefinitions();
        if ((isset($definitions[__CLASS__]) && isset($definitions[__CLASS__]['class']))) {
            return Yii::createObject(CategoryQuery::className(), [$definitions[__CLASS__]['class']]);
        }
        return Yii::createObject(CategoryQuery::className(), [get_called_class()]);
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title'], 'required'],
            [['parent_id'], 'default', 'value' => self::ROOT_PARENT],
            [['parent_id'], 'integer'],
            [['beforeId'], 'safe'],
            [['title'], 'string', 'max' => 255],
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParent()
    {
        return $this->hasOne(self::className(), ['id' => 'parent_id'])
            ->alias('parents');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getChildren()
    {
        return $this->hasMany(self::className(), ['parent_id' => 'id'])
            ->alias('children');
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('category', 'ID'),
            'title' => Yii::t('category', 'Title'),
            'parent_id' => Yii::t('category', 'Parent ID'),
        ];
    }

    /**
     * @param bool $insert
     * @param array $changedAttributes
     */
    public function afterSave($insert, $changedAttributes)
    {
        if ($insert) {
            $this->createParentsRecords();
        } else {
            if (isset($changedAttributes['parent_id']) && ((int)$changedAttributes['parent_id'] !== (int)$this->parent_id)) {
                $oldParent = self::findOne(['id' => $changedAttributes['parent_id']]);
                if ($oldParent) {
                    self::getDb()->createCommand()
                        ->delete($this->getClosureTableName(), ['child_id' => $this->id,])
                        ->execute();

                    $allChildrenIds = $this->getDescendants()->column();
                    self::getDb()->createCommand()
                        ->delete($this->getClosureTableName(), ['child_id' => $allChildrenIds])
                        ->execute();
                }

                $this->createParentsRecordsRecursive();
            }
        }
        parent::afterSave($insert, $changedAttributes);
    }

    /**
     *
     */
    protected function createParentsRecords()
    {
        if (($parent = $this->parent) !== null) {
            $parents = $parent->parents;
            $parents[] = $parent;
            foreach ($parents as $level => $item) {
                $model = Yii::createObject($this->closureClass);
                $model->child_id = $this->id;
                $model->parent_id = $item->id;
                $model->level = $level + 1;
                $model->save(false);
            }
        }
    }

    /**
     * @return ActiveQuery
     */
    public function getDescendants()
    {
        return $this->hasMany(self::className(), ['id' => 'child_id'])
            ->viaTable($this->getClosureTableName(), ['parent_id' => 'id'])
            ->alias('descendants');
    }

    /**
     *
     */
    protected function createParentsRecordsRecursive()
    {
        $this->createParentsRecords();
        foreach ($this->children as $child) {
            $child->createParentsRecordsRecursive();
        }
    }

    /**
     * @return ActiveQuery
     */
    public function getParents()
    {
        return $this->hasMany(self::className(), ['id' => 'parent_id'])
            ->viaTable($this->getClosureTableName(), ['child_id' => 'id'])
            ->alias('parents');
    }

    /**
     * @throws \yii\db\Exception
     */
    public function afterDelete()
    {
        self::getDb()->createCommand()
            ->update(static::tableName(), ['parent_id' => $this->parent_id], ['parent_id' => $this->id])
            ->execute();
        parent::afterDelete();
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%category}}';
    }

    /**
     * Move child nodes to parent
     * @return bool
     * @throws \yii\db\Exception
     */
    public function beforeDelete()
    {
        $depth = $this->getDepth();
        $allChildrenIds = $this->getDescendants()->select('id')->column();

        self::getDb()->createCommand()
            ->update($this->getClosureTableName(), [
                'level' => new Expression('level-1'),
            ], ['and', ['>', 'level', $depth], ['child_id' => $allChildrenIds]])->execute();
        return parent::beforeDelete();
    }

    /**
     * @return mixed
     */
    public function getDepth()
    {
        /** @var ActiveQuery $query */
        $query = call_user_func([$this->closureClass, 'find']);
        return $query
            ->where(['child_id' => $this->id])
            ->orderBy(['level' => SORT_DESC])
            ->limit(1)
            ->max('level');
    }

    /**
     * @param bool $insert
     * @return bool
     */
    public function beforeSave($insert)
    {
        if ($insert) {
            $sort_order = $this->getSiblings()->max('sort_order');
            $this->sort_order = $sort_order + 1;
        } else {
            if ($this->beforeId !== null) {
                $this->changeOrder((int)$this->beforeId);
            }
        }
        return parent::beforeSave($insert);
    }

    /**
     * @return ActiveQuery
     */
    public function getSiblings()
    {
        $query = self::find()->siblings($this);
        $query->multiple = true;
        return $query;
    }

    /**
     * @param $before
     */
    protected function changeOrder($before)
    {
        if ($before) {
            /** @var Category $prev */
            $prevSortOrder = self::find()
                ->andWhere(['id' => $before])
                ->limit(1)
                ->min('sort_order');

            $nextSortOrder = self::find()
                ->andWhere(['>', 'sort_order', (float)$prevSortOrder])
                ->andWhere(['parent_id' => $this->parent_id])
                ->limit(1)
                ->min('sort_order');

            if ($nextSortOrder > $prevSortOrder) {
                $newOrder = ($prevSortOrder + $nextSortOrder) / 2;
            } else {
                $newOrder = $prevSortOrder + 1;
            }
        } else {
            $prevSortOrder = self::find()
                ->andWhere(['parent_id' => $this->parent_id])
                ->limit(1)
                ->min('sort_order');
            $newOrder = $prevSortOrder / 2;
        }

        $this->sort_order = $newOrder;
    }

    /**
     * Return closure table name
     * @return string
     */
    protected function getClosureTableName()
    {
        return call_user_func([$this->closureClass, 'tableName']);
    }
}
