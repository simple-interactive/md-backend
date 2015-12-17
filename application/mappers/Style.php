<?php
/**
 * @class App_Map_Style
 */
class App_Map_Style extends Mongostar_Map_Instance
{
    /**
     * @return array
     */
    public function rulesCommon()
    {
        return [
            'colors' => 'colors',
            'backgroundImage' => 'backgroundImage',
            'company' => 'company'
        ];
    }
} 