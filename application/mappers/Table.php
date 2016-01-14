<?php

/**
 * @class App_Map_Table
 */
class App_Map_Table extends Mongostar_Map_Instance
{
    /**
     * @return array
     */
    public function rulesCommon()
    {
        return [
            'id'     => 'id',
            'name'   => 'name',
            'token'  => 'token',
            'pair'   => 'pair',
            'status' => 'status'
        ];
    }

    /**
     * @return array
     */
    public function rulesDispatcher()
    {
        return [
            'id' => 'id',
            'name' => 'name',
            'orders' => 'orders'
        ];
    }

    public function getOrders(App_Model_Table $table)
    {
        return App_Map_Order::execute(App_Model_Order::fetchAll([
            'tableId' => (string) $table->id,
            'status' => ['$ne' => App_Model_Order::STATUS_SUCCESS],
            'payStatus' => ['$ne' => App_Model_Order::PAY_STATUS_YES]
        ]));
    }
}