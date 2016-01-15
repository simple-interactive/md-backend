<?php

class CallController extends Default_Controller_Base
{
    public function waiterAction()
    {
        $deviceService = new App_Service_Device();
        $deviceService->callWaiter($this->table);
    }
}