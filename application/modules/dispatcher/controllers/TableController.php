<?php

class Dispatcher_TableController extends Dispatcher_Controller_Base
{

    public function indexAction()
    {
        if ($this->getRequest()->isPost()) {
            $this->view->table = App_Map_Table::execute($this->getDispatcherService()->saveTable(
              $this->getParam('name', false),
              $this->getParam('token', false),
              $this->getParam('status',  false)
            ));
        }
        else if ($this->getRequest()->isGet()) {
            $this->view->tables = App_Map_Table::execute($this->getDispatcherService()->getTableList());
        }
    }

    public function removeAction()
    {
        if ($this->getRequest()->isPost()) {
            $this->getDispatcherService()->removeTable(
                App_Model_Table::fetchOne(['token' => $this->getParam('token', false)])
            );
        }
        else {
            throw new \Exception('method-unsupported', 400);
        }
    }
}