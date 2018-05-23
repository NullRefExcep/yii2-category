<?php

use yii\db\Migration;

/**
 * This is example migration class to bind category with another entity (for example product)
 * You can base your own migration on this code
 *
 * @author    Dmytro Karpovych
 * @copyright 2018 NRE
 */
class add_product_category_migration extends Migration
{
    public function safeUp()
    {
        $this->createTable('{{%product_has_category}}', [
            'category_id' => $this->integer(),
            'product_id' => $this->integer(),
            'PRIMARY KEY(category_id, product_id)',
        ]);

        // creates index for column `category_id`
        $this->createIndex(
            'idx-category_product-category_id',
            '{{%product_has_category}}',
            'category_id'
        );

        // add foreign key for table `category`
        $this->addForeignKey(
            'fk-category_product-category_id',
            '{{%product_has_category}}',
            'category_id',
            '{{%category}}',
            'id',
            'CASCADE'
        );

        // creates index for column `product_id`
        $this->createIndex(
            'idx-category_product-product_id',
            '{{%product_has_category}}',
            'product_id'
        );

        // add foreign key for table `product`
        $this->addForeignKey(
            'fk-category_product-product_id',
            '{{%product_has_category}}',
            'product_id',
            '{{%product}}',
            'id',
            'CASCADE'
        );
    }

    /**
     *
     */
    public function safeDown()
    {
        // drops foreign key for table `category`
        $this->dropForeignKey(
            'fk-category_product-category_id',
            '{{%product_has_category}}'
        );

        // drops index for column `category_id`
        $this->dropIndex(
            'idx-category_product-category_id',
            '{{%product_has_category}}'
        );

        // drops foreign key for table `product`
        $this->dropForeignKey(
            'fk-category_product-product_id',
            '{{%product_has_category}}'
        );

        // drops index for column `product_id`
        $this->dropIndex(
            'idx-category_product-product_id',
            '{{%product_has_category}}'
        );

        $this->dropTable('{{%product_has_category}}');
    }
}