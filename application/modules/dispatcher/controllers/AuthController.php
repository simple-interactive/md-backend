<?php

class Dispatcher_AuthController extends Zend_Controller_Action
{
    public function indexAction()
    {
        $config = Zend_Registry::get('config');
        if ($config['dispatcher']['login'] === $this->getParam('login')
            && $config['dispatcher']['password'] === $this->getParam('password')){
            $this->view->success = true;
            $this->view->user = [
                'token' => $config['dispatcher']['token'],
                'email' => 'simple@simple.simple'
            ];
        }
        else {
            $this->view->success = false;
        }
    }
}