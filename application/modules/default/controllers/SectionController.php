<?php

class SectionController extends Default_Controller_Base
{
    use App_Trait_MenuService;

    public function indexAction()
    {
        $this->view->section = App_Map_Section::execute(
            $this->getMenuService()->getSection(
                $this->getParam('id')
            )
        );
    }

    public function listAction()
    {
        $this->view->sections = App_Map_Section::execute(
            $this->getMenuService()->getSectionList(
                $this->getParam('parentId')
            )
        );
    }

    public function treeAction(){
        $this->view->sections = $this->getMenuService()->treeSections();
    }
} 