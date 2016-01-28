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
            $this->log->info(__CLASS__.' start');
            $this->syncService->uploadChanges();
            $this->log->info(__CLASS__.' finish');
        }
        catch (Exception $e) {
            $this->log->err('SyncController error', $e);
            $lock->unlock();
            throw $e;
        }
        $lock->unlock();
    }
}