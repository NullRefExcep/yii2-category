<?php

namespace nullref\category\migrations;

use nullref\core\traits\MigrationTrait;
use yii\db\Migration;

/**
 * Handles the creation tables for categories.
 */
class M160329210118Create_categories_tables extends Migration
{
    use MigrationTrait;

    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        if (!$this->tableExist('{{%category}}')) {

            $this->createTable('{{%category}}', [
                'id' => $this->primaryKey(),
                'title' => $this->string(),
                'parent_id' => $this->integer()->notNull(),
                'sort_order' => $this->float()->defaultValue(1),
            ], $this->getTableOptions());

            $this->createTable('{{%category_closure}}', [
                'child_id' => $this->integer()->notNull(),
                'parent_id' => $this->integer()->notNull(),
                'level' => $this->integer()->notNull()->defaultValue(0),
            ], $this->getTableOptions());

            $this->createIndex('category_fk_parent', '{{%category}}', 'parent_id');

            $this->addPrimaryKey('category_closure_pk', '{{%category_closure}}', ['child_id', 'parent_id', 'level']);
            $this->addForeignKey('category_fk_parents', '{{%category_closure}}', 'child_id', '{{%category}}', 'id', 'CASCADE');
            $this->addForeignKey('category_fk_parent', '{{%category_closure}}', 'parent_id', '{{%category}}', 'id', 'CASCADE');
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
