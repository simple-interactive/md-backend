<?php

abstract class Dispatcher_Controller_Base extends Zend_Controller_Action
{
    use App_Trait_DispatcherService;

    public function init()
    {
        parent::init();
        if ( ! $this->getDispatcherService()->checkToken(
            $this->getRequest()->getHeader('x-auth', false)
        )) {
            throw new Exception("Forbidden", 403);
        }
    }
}