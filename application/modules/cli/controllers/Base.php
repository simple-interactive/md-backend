<?php

abstract class Cli_Controller_Base extends Zend_Controller_Action
{
    /**
     * @var App_Service_Sync
     */
    public $syncService;

    public function init()
    {
        parent::init();
        $this->syncService = new App_Service_Sync();
    }
}