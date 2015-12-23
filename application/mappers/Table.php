<?php

/**
 * @class App_Map_Table
 */
class App_Map_Table extends Mongostar_Map_Instance
{
    /**
     * @return array
     */
    public function rulesCommon()
    {
        return [
            'name' => 'name',
            'token' => 'token',
            'status' => 'status'
        ];
    }
}