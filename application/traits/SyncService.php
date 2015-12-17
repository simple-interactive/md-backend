<?php

/**
 * @class SyncService
 */
trait App_Trait_SyncService
{
    /**
     * @var App_Service_Sync
     */
    private $_syncService;

    /**
     * @return App_Service_Sync
     */
    public function getSyncService()
    {
        if ($this->_syncService == null){
            $this->_syncService = new App_Service_Sync();
        }
        return $this->_syncService;
    }
} 