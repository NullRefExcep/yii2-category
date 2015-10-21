<?php

use yii\db\Migration;
use yii\db\Schema;

class m150920_102200_create_category_table extends Migration
{
    use \nullref\core\traits\MigrationTrait;

    protected $tableName = '{{%category}}';

    public function up()
    {
        if (!$this->tableExist($this->tableName)) {
            $tableOptions = null;
            if (\Yii::$app->db->driverName === 'mysql') {
                $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
            }
            $this->createTable($this->tableName, [
                'id' => Schema::TYPE_PK,
                'title' => Schema::TYPE_STRING,
                'slug' => Schema::TYPE_STRING,
                'parentId' => Schema::TYPE_INTEGER,
                'type' => Schema::TYPE_INTEGER . ' NULL',
                'status' => Schema::TYPE_INTEGER,
                'image' => Schema::TYPE_STRING,
                'description' => Schema::TYPE_TEXT,
                'data' => Schema::TYPE_TEXT,
                'deleted' => Schema::TYPE_BOOLEAN,
                'order' => Schema::TYPE_INTEGER,
                'createdAt' => Schema::TYPE_INTEGER . ' NOT NULL',
                'updatedAt' => Schema::TYPE_INTEGER . ' NOT NULL',
            ], $tableOptions);
        }
    }

    public function down()
    {
        if ($this->tableExist($this->tableName)) {
            $this->dropTable($this->tableName);
        }
        return true;
    }

}
