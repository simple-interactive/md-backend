<?php

abstract class Cli_Controller_Base extends Zend_Controller_Action
{
    /**
     * @var App_Service_Sync
     */
    protected $syncService;

    /**
     * @var App_Helper_Log
     */
    protected $log;

    public function init()
    {
        parent::init();
        $this->log = new App_Helper_Log();
        $config = Zend_Registry::get('config');
        $this->syncService = new App_Service_Sync(
            $config ['crm']['url'],
            $config ['crm']['token'],
            $config ['url']
        );
    }
}