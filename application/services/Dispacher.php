<?php

/**
 * @class App_Service_Dispacher
 */
class App_Service_DispacherService
{

    /**
     * @param string $name
     * @param string $token
     * @param string $status
     *
     * @return App_Model_Table|null
     */
    public function saveTable($name, $token, $status)
    {
        $table = App_Model_Table::fetchOne([
            'token' => $token
        ]);

        if (!$table) {
            $table = App_Model_Table();
        }

        $table->name = $name;
        $table->token = $token;
        $table->status = $status;
        $table->save();
        return $table;
    }

    /**
     * @var string $id
     */
    public function removeTable($id)
    {
        App_Model_Table::remove([
            'id' => $id
        ]);
    }
    public function getTableList()
    {
        return App_Model_Table::fetchAll();
    }
}