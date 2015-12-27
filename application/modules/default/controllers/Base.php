<?php

abstract class Default_Controller_Base extends Zend_Controller_Action
{
    /**
     * @var App_Model_Table
     */
    protected $table;

    public function init()
    {
        parent::init();
        $deviceService = new App_Service_Device();
        $this->table = $deviceService->identify($this->getRequest()->getHeader('x-auth', false));
        if (!$this->table) {
            throw new Exception("Forbidden", 403);
        }
    }
}