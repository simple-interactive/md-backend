<?php

class Dispatcher_OrderController extends Dispatcher_Controller_Base
{

    /**
     * @var App_Service_Statistics
     */
    private $_statistics;

    public function init()
    {
        $this->_statistics = new App_Service_Statistics();
    }

    public function listAction()
    {
      $this->view->orders = App_Map_Order::execute(
          App_Model_Order::fetchAll([
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

    public function ordersAction()
    {
        if ( ! $this->getRequest()->isGet()) {
            throw new \Exception('unsupported-method');
        }
        $this->view->orders = App_Map_Order::execute($this->_statistics->getOrders(
            $this->getParam('timeStart', null),
            $this->getParam('timeEnd', null),
            $this->getParam('offset', 0),
            $this->getParam('count', 10),
            App_Model_Section::fetchOne([
                'id' => $this->getParam('sectionId', null)
            ])
        ));
        $this->view->count = $this->_statistics->getCountOrders(
            $this->getParam('timeStart', null),
            $this->getParam('timeEnd', null)
        );
    }
}