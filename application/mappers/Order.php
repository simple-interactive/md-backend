<?php

/**
 * @class App_Map_Order
 */
class App_Map_Order extends Mongostar_Map_Instance
{
    public function rulesCommon()
    {
        return [
            'id' => 'id',
            'data' => 'data',
            'tableId' => 'tableId',
            'status' => 'status',
            'payStatus' => 'payStatus'
        ];
    }
}