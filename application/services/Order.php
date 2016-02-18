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
            'tableId' => (string)$table->id,
            'createdDate' => time(),
            'isPushed' => App_Model_Order::PUSH_STATUS_NO,
            'paymentMethod' => App_Model_Order::PAYMENT_METHOD_CASH
        ]);
        $order->save();
    }

    /**
     * @param App_Model_Order $order
     */
    public function cancel(App_Model_Order $order)
    {
        $order->status = App_Model_Order::STATUS_CANCELED;
        $order->save();
    }
}