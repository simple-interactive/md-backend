<?php

class Dispatcher_IndexController extends Dispatcher_Controller_Base
{
    public function indexAction()
    {
        $tableService = new App_Service_Device();

        $this->view->tables = App_Map_Table::execute(
            $tableService->getActiveTables(),
            'updater'
        );
    }
}