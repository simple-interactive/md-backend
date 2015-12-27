<?php

class PairController extends Zend_Controller_Action
{
    /**
     * @var App_Service_Device
     */
    public $deviceService;
    
    public function init()
    {
        parent::init();
        if (!$this->getRequest()->isPost()) {
            throw new \Exception('unsupported-method', 400);
        }
        $this->deviceService = new App_Service_Device();
    }

    public function indexAction()
    {
        $this->deviceService->pairTable(
            App_Model_Table::fetchOne([
                'token' => $this->getParam('token', false)
            ])
        );
    }

    public function checkAction()
    {
        $table = App_Model_Table::fetchOne([
            'token' => $this->getParam('token', false)
        ]);
        if (!$table) {
            throw new Exception('table-not-found', 400);
        }
        $this->view->pair = $table->pair;

    }
}