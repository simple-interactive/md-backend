<?php

/**
 * @class ProductController
 */
class ProductController extends Zend_Controller_Action {

    use App_Trait_MenuService;

    public function indexAction()
    {

        if ($this->getRequest()->isGet()) {
            $this->view->product = App_Map_Product::execute(
                $this->getMenuService()->getProduct($this->getParam('id', false))
            );
        }
        else {
            throw new Exception('unsupported-method', 400);
        }
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

    public function sectionAction()
    {
        if (!$this->getRequest()->isGet()) {
            throw new Exception('unsupported-method', 400);
        }
        $this->view->products = App_Map_Product::execute($this->getMenuService()->getProductListBySection(
                App_Model_Section::fetchOne(['id' => $this->getParam('sectionId',  false)]),
                $this->getParam('offset', 0),
                $this->getParam('limit', 10)
            )
        );
        $this->view->count = $this->getMenuService()->getProductCountBySection(
            App_Model_Section::fetchOne(['id' => $this->getParam('sectionId',  false)])
        );
    }

//    public function searchAction()
//    {
//        if (!$this->getRequest()->isGet()) {
//            throw new Exception('unsupported-method', 400);
//        }
//        $this->view->products = App_Map_Product::execute($this->getMenuService()->getProductListBySearch(
//                $this->user,
//                $this->getParam('search', false),
//                $this->getParam('offset', 0),
//                $this->getParam('limit', 10)
//        ));
//        $this->view->count = $this->getMenuService()->getProductCountBySearch(
//            $this->user,
//            $this->getParam('search', false)
//        );
//    }
} 