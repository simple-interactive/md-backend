<?php

/**
 * @trait App_Trait_DispatcherService
 */
trait App_Trait_DispatcherService
{
    /**
     * @var App_Trait_DispatcherService
     */
    private $_dispacherService;

    /**
     * @return App_Service_Dispatcher
     */
    public function getDispatcherService()
    {
        if ($this->_dispacherService == null){
            $this->_dispacherService = new App_Service_Dispatcher();
        }
        return $this->_dispacherService;
    }

}