<?php

class Dispatcher_IndexController extends Default_Controller_Base
{
    public function indexAction()
    {
        $deviceService = new App_Service_Device();
        $this->view->wait = App_Map_Table::execute(
            $deviceService->getWaitTables()
        );

        $deviceService = new App_Service_Order();
        $this->view->orders = App_Map_Order::execute(
            $deviceService->getUntrackedOrders()
        );
    }
}