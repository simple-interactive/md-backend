<?php

abstract class Dispatcher_Controller_Base extends Zend_Controller_Action
{
    public function init()
    {
        parent::init();
        $config = Zend_Registry::get('config');
        if ( $config ['dispatcher']['token'] !== $this->getRequest()->getHeader('x-auth', false)) {
            throw new Exception("Forbidden", 403);
        }
    }
}