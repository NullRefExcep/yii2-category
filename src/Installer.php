<?php
/**
 * @author    Dmytro Karpovych
 * @copyright 2015 NRE
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

namespace nullref\category;


use nullref\core\components\ModuleInstaller;
use yii\db\Schema;

class Installer extends ModuleInstaller
{
    public function getModuleId()
    {
        return 'category';
    }

    protected $tableName = '{{%category}}';

    /**
     * Create table
     */
    public function install()
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

        parent::install();
    }

    /**
     * Drop table
     */
    public function uninstall()
    {
        if ($this->tableExist($this->tableName)) {
            $this->dropTable($this->tableName);
        }
        parent::uninstall();
    }


} 