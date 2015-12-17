<?php

/**
 * @class App_Helper_Log
 */
class App_Helper_Log extends Zend_Log
{
    public function __construct()
    {
        $config = Zend_Registry::get('config');
        $path = APPLICATION_PATH.
            DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.$config['log']['file'];

        $writer = new Zend_Log_Writer_Stream($path);
        parent::__construct($writer);
    }
}