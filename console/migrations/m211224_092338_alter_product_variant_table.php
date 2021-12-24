<?php

use common\models\ProductVariant;
use yii\db\Migration;

/**
 * Class m211224_092338_alter_product_variant_table
 */
class m211224_092338_alter_product_variant_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
			$this->alterColumn(ProductVariant::tableName(),'sku',$this->string(100));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m211224_092338_alter_product_variant_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m211224_092338_alter_product_variant_table cannot be reverted.\n";

        return false;
    }
    */
}
