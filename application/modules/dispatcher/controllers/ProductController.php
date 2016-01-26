<?php

/**
 * @class ProductController
 */
class Dispatcher_ProductController extends Default_Controller_Base
{
    use App_Trait_MenuService;
    /**
     * @var App_Service_Sync
     */
    private $_syncService;

    public function init()
    {
        parent::init();
        $config = Zend_Registry::get('config');
        $this->_syncService = new App_Service_Sync($config['protocol'].'://'.$config['host']);
    }

    public function listAction()
    {
        if (!$this->getRequest()->isGet()) {
            throw new Exception('unsupported-method', 400);
        }
        $this->view->products = App_Map_Product::execute($this->getMenuService()->getProductList(
            $this->getParam('offset', 0),
            $this->getParam('limit', 10))
        );
        $this->view->count = $this->getMenuService()->getProductCount();
    }

    public function existsAction()
    {
        $this->getMenuService()->setProductExists(
            $this->getParam('id', null),
            $this->getParam('exists', null)
        );

        $config = Zend_Registry::get('config');
        $this->_syncService->pushProductExists(
            $config ['crm']['url'],
            $config ['crm']['token'],
            $this->getParam('id', null),
            $this->getParam('exists', null)
        );
    }
} 