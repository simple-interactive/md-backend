<?php

class Cli_SyncController extends Cli_Controller_Base
{
    public function indexAction()
    {
        $lock = new App_Helper_Lock(__CLASS__);
        if ($lock->isLock() === true) {
            die('Lock file ' + __CLASS__);
        }
        $lock->lock();
        try {
            $config = Zend_Registry::get('config');
            $this->syncService->uploadChanges(
                $config ['crm']['url'],
                $config ['crm']['token']
            );
        }
        catch (Exception $e) {
            $lock->unlock();
            throw $e;
        }
        $lock->unlock();
    }
} 