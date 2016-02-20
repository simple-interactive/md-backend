<?php

class KeyController extends Default_Controller_Base
{
    public function indexAction()
    {
        $this->view->keys = [
            'publicKey' => 'i20924400675',
            'privateKey' => '1NrICG0KFE7kbMbcpmWvKoy77Fi82x2SVYih1Ub7'
        ];
    }
}