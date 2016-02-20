<?php

class OrderController extends Default_Controller_Base
{
    /**
     * @var App_Service_Order
     */
    protected $orderService;

    public function init()
    {
        parent::init();
        $this->orderService = new App_Service_Order();
    }

    public function indexAction()
    {
        if ($this->getRequest()->isPost()) {
            $this->orderService->createOrder(
               $this->getParam('order', null),
                $this->getParam('paymentMethod', null),
                $this->table
            );
        }
        else {
            throw new Exception('unsupported-method', 400);
        }
    }
}