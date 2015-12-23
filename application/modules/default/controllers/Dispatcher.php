<?php

class App_Controller_Dispatcher extends Zend_Controller_Action
{
    use App_Trait_DispatcherService;

    public function init()
    {
        parent::init();
        if ( ! $this->getDispatcherService()->checkToken(
            $this->getRequest()->getHeader('x-auth', false)
        )) {
            throw new Exception(null, 403);
        }
    }

}