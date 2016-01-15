<?php

class Dispatcher_OrderController extends Dispatcher_Controller_Base
{
    public function listAction()
    {
      $this->view->orders = App_Map_Order::execute(
          App_Model_Order::fetchAll([

              /*
              '$or' => [
                  [
                      'status' => App_Model_Order::STATUS_SUCCESS,
                      'payStatus' => App_Model_Order::PAY_STATUS_NO
                  ],
                  [
                      'status' => App_Model_Order::STATUS_NEW,
                      'payStatus' => App_Model_Order::PAY_STATUS_NO
                  ],
                  [
                      'status' => App_Model_Order::STATUS_NEW,
                      'payStatus' => App_Model_Order::PAY_STATUS_YES
                  ]
              ]
              */

              'status' => ['$ne' => App_Model_Order::STATUS_SUCCESS],
              'payStatus' => ['$ne' => App_Model_Order::PAY_STATUS_YES],
          ])
      );
    }

    public function payAction()
    {
        $order = App_Model_Order::fetchOne([
            'id' => $this->getParam('orderId', null)
        ]);
        $order->payStatus = $this->getParam('status');
        $order->save();
    }

    public function statusAction()
    {
        $order = App_Model_Order::fetchOne([
            'id' => $this->getParam('orderId', null)
        ]);
        $order->status = $this->getParam('status', null);
        $order->save();
    }
}