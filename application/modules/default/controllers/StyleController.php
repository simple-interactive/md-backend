<?php

class StyleController extends Default_Controller_Base
{

    public function indexAction()
    {
        $this->view->style = App_Map_Style::execute(App_Model_Style::fetchOne());
    }
} 
