<?php

/**
 * @class ProductController
 */
class Dispatcher_ProductController extends Zend_Controller_Action
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
        $this->_syncService = new App_Service_Sync($config['crm']['url'], $config['crm']['token']);
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
        if (!$this->getRequest()->isPost()) {
            throw new Exception('unsupported-method', 400);
        }
        $this->getMenuService()->setProductExists(
            $this->getParam('id', null),
            $this->getParam('exists', null)
        );
        $this->_syncService->pushProductExists(
            $this->getParam('id', null),
            $this->getParam('exists', null)
        );
    }

    public function searchAction()
    {
        if (!$this->getRequest()->isGet()) {
            throw new Exception('unsupported-method', 400);
        }
        $this->view->products = App_Map_Product::execute($this->getMenuService()->getProductListBySearch(
            $this->getParam('search', false),
            $this->getParam('offset', 0),
            $this->getParam('limit', 10)
        ));
        $this->view->count = $this->getMenuService()->getProductCountBySearch(
            $this->getParam('search', false)
        );
    }
} 