<?php

class Dispatcher_TableController extends Dispatcher_Controller_Base
{
    /**
     * @var App_Service_Device
     */
    public $deviceService;

    public function init()
    {
        parent::init();
        $this->deviceService = new App_Service_Device();
    }

    public function indexAction()
    {
        if ($this->getRequest()->isPost()) {

            $this->view->table = App_Map_Table::execute(
                $this->deviceService->saveTable(
                    $this->getParam('id', false),
                    $this->getParam('name', false),
                    $this->getParam('token', false),
                    $this->getParam('status',  false)
                )
            );
        }
        else if ($this->getRequest()->isGet()) {

            $this->view->table = App_Map_Table::execute(
                $this->deviceService->getTable(
                    $this->getParam('id', false)
                )
            );
        }
    }

    public function removeAction()
    {
        if ($this->getRequest()->isPost()) {
            $this->deviceService->removeTable(
                App_Model_Table::fetchOne([
                    'id' => $this->getParam('id', false)
                ])
            );
        }
        else {
            throw new \Exception('method-unsupported', 400);
        }
    }

    public function listAction()
    {
        $this->view->tables = App_Map_Table::execute(
            $this->deviceService->getTableList()
        );
    }

    public function stopCallingWaiterAction()
    {
        $this->deviceService->stopCallingWaiter(
            App_Model_Table::fetchOne([
                'id' => $this->getParam('id')
            ])
        );
    }
}