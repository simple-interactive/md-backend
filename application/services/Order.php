<?php

/**
 * @class App_Service_Order
 */
class App_Service_Order
{
    /**
     * @param array $data
     * @param App_Model_Table $table
     */
    public function createOrder(array $data, App_Model_Table $table)
    {
        foreach ($data as &$item) {
            $product = App_Model_Product::fetchOne([
                'id' => $item ['product']
            ]);
            $item ['product'] = App_Map_Product::execute($product, 'order');
        }
        $order = new App_Model_Order([
            'data' => $data,
            'status' => App_Model_Order::STATUS_NEW,
            'payStatus' => App_Model_Order::PAY_STATUS_NO,
            'tableId' => (string)$table->id
        ]);
        $order->save();
    }

    /**
     * @return App_Model_Order[]
     */
    public function getUntrackedOrders()
    {
        return App_Model_Order::fetchAll([
            'status' => ['$ne' => App_Model_Order::STATUS_SUCCESS],
            'payStatus' => ['$ne' => App_Model_Order::PAY_STATUS_YES],
        ]);
    }
}