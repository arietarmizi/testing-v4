<?php

use common\models\ProductVariant;
use yii\db\Migration;

/**
 * Class m211224_113408_add_column_product_variant
 */
class m211224_113408_add_column_product_variant extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
			$this->addColumn(ProductVariant::tableName(),'marketplaceProductId',$this->string(36));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m211224_113408_add_column_product_variant cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m211224_113408_add_column_product_variant cannot be reverted.\n";

        return false;
    }
    */
}
