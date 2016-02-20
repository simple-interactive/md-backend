<?php

class SettingsController extends Default_Controller_Base
{
    public function indexAction()
    {
        $settings = App_Model_Settings::fetchOne();
        $this->view->settings = $settings->data;
    }
}