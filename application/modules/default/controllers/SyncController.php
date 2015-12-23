<?php

class SyncController extends Zend_Controller_Action
{
    use App_Trait_SyncService;

    public function indexAction()
    {
        $lock = new App_Helper_Lock(__CLASS__);
        if ($lock->isLock() === true) {
           return;
        }
        $lock->lock();
        try {
            $config = Zend_Registry::get('config');
            $this->getSyncService()->uploadChanges(
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