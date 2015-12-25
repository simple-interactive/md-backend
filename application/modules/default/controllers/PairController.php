<?php

class PairController extends Zend_Controller_Action
{
    use App_Trait_DispatcherService;

    public function init()
    {
        parent::init();
        if (!$this->getRequest()->isPost()) {
            throw new \Exception('unsupported-method', 400);
        }
    }

    public function indexAction()
    {
        $this->getDispatcherService()->pairTable(
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
            throw new Exception('table-not-found');
        }
        $this->view->pair = $table->pair;

    }
}