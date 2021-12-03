<?php


namespace api\forms\stockmanagement;


use api\components\BaseForm;
use common\models\StockManagement;

class StoreStockManagementForm extends BaseForm
{
    public $warehouseId;
    public $productVariantId;
    public $promotionStock;
    public $orderedStock;
    public $availableStock;
    public $onHandStock;
    public $stockAlert;
    public $stockType;
    public $status;

    private $_query;

    public function rules()
    {
        return [
            [['warehouseId', 'productVariantId', 'availableStock', 'onHandStock'], 'required'],
            [['promotionStock', 'orderedStock', 'availableStock', 'onHandStock', 'stockAlert'], 'double'],
            ['stockType', 'in', 'range' => array_keys(StockManagement::stocks())]
        ];
    }

    public function submit()
    {
        $query = new StockManagement();

        $query->warehouseId      = $this->warehouseId;
        $query->productVariantId = $this->productVariantId;
        $query->promotionStock   = $this->promotionStock;
        $query->orderedStock     = $this->orderedStock;
        $query->availableStock   = $this->availableStock;
        $query->onHandStock      = $this->onHandStock;
        $query->stockAlert       = $this->stockAlert;
        $query->stockType        = $this->stockType ? $this->stockType : StockManagement::stocks();

        $query->save();
        $query->refresh();

        $this->_query = $query;
        return true;
    }

    public function response()
    {
        $query = $this->_query->toArray();

        unset($query['createdAt']);
        unset($query['updatedAt']);

        return ['stockManagement' => $query];
    }
}