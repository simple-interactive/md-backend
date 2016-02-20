<?php

class SettingsController extends Default_Controller_Base
{
    public function indexAction()
    {
        $this->view->keys = App_Map_Settings::execute(
            App_Model_Settings::fetchOne()
        );
    }
}