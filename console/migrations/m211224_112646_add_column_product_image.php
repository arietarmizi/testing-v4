<?php

use common\models\ProductImages;
use yii\db\Migration;

/**
 * Class m211224_112646_add_column_product_image
 */
class m211224_112646_add_column_product_image extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
			$this->addColumn(ProductImages::tableName(),'originalURL',$this->string(100));
			$this->addColumn(ProductImages::tableName(),'ThumbnailURL',$this->string(100));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m211224_112646_add_column_product_image cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m211224_112646_add_column_product_image cannot be reverted.\n";

        return false;
    }
    */
}
