<?php

use nullref\category\models\Category;
use nullref\core\traits\MigrationTrait;
use yii\db\Migration;

/**
 * Handles the creation tables for categories.
 */
class m160329_210118_create_categories_tables extends Migration
{
    use MigrationTrait;

    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        if (!$this->tableExist('{{%category}}')) {
            $tableOptions = null;
            if ($this->db->driverName === 'mysql') {
                $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
            }

            $this->createTable('{{%category}}', [
                'id' => $this->primaryKey(),
                'title' => $this->string(),
                'parent_id' => $this->integer()->notNull(),
                'sort_order' => $this->float()->defaultValue(1),
            ], $tableOptions);

            $this->createTable('{{%category_closure}}', [
                'child_id' => $this->integer()->notNull(),
                'parent_id' => $this->integer()->notNull(),
                'level' => $this->integer()->notNull()->defaultValue(0),
            ], $tableOptions);

            $this->createIndex('category_fk_parent', '{{%category}}', 'parent_id');

            $this->addPrimaryKey('category_closure_pk', '{{%category_closure}}', ['child_id', 'parent_id', 'level']);
            $this->addForeignKey('category_fk_parents', '{{%category_closure}}', 'child_id', '{{%category}}', 'id', 'CASCADE');
            $this->addForeignKey('category_fk_parent', '{{%category_closure}}', 'parent_id', '{{%category}}', 'id', 'CASCADE');
        }

        for ($i = 1; $i <= 3; $i++) {
            $model = new Category();
            $model->title = 'Category ' . $i;
            $model->save();
            $parent_id = $model->id;
            for ($j = 1; $j <= 2; $j++) {
                $model = new Category();
                $model->title = 'Category ' . $i . '.' . $j;
                $model->parent_id = $parent_id;
                $model->save();
                $parent_id_j = $model->id;
                for ($k = 1; $k <= 2; $k++) {
                    $model = new Category();
                    $model->title = 'Category ' . $i . '.' . $j . '.' . $k;
                    $model->parent_id = $parent_id_j;
                    $model->save();
                    $parent_id_k = $model->id;
                    for ($z = 1; $z <= 2; $z++) {
                        $model = new Category();
                        $model->title = 'Category ' . $i . '.' . $j . '.' . $k . '.' . $z;
                        $model->parent_id = $parent_id_k;
                        $model->save();
                    }
                }
            }
        }
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropForeignKey('category_fk_parent', '{{%category_closure}}');
        $this->dropForeignKey('category_fk_parents', '{{%category_closure}}');

        $this->dropIndex('category_fk_parent', '{{%category}}');

        $this->dropTable('{{%category_closure}}');
        $this->dropTable('{{%category}}');
        return true;
    }
}
