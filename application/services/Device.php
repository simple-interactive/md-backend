<?php

/**
 * @class App_Service_Device
 */
class App_Service_Device
{

    /**
     * @param string $name
     * @param string $token
     * @param string $status
     *
     * @return App_Model_Table|null
     * @throws Exception
     */
    public function saveTable($name, $token, $status)
    {
        $table = App_Model_Table::fetchOne([
            'token' => $token
        ]);
        if (!$table) {
            $table = new App_Model_Table();
            $table->pair = App_Model_Table::PAIR_NO;
        }

        if (mb_strlen($name, 'UTF-8') == 0 && mb_strlen($name, 'UTF-8') > 30) {
            throw new \Exception('name-invalid', 400);
        }
        if (mb_strlen($token, 'UTF-8') == 0 && mb_strlen($token, 'UTF-8') > 32) {
            throw new \Exception('token-invalid', 400);
        }
        if ($status != App_Model_Table::STATUS_ACTIVE &&
            $status != App_Model_Table::STATUS_LOCK) {
            throw new \Exception('status-invalid', 400);
        }

        $table->name = $name;
        $table->token = $token;
        $table->status = $status;
        $table->save();

        return $table;
    }

    /**
     * @var App_Model_Table $table
     */
    public function removeTable(App_Model_Table $table)
    {
        App_Model_Table::remove([
            'id' => $table->id
        ]);
    }

    /**
     * @return App_Model_Table[]
     */
    public function getTableList()
    {
        return App_Model_Table::fetchAll();
    }

    /**
     * @param App_Model_Table $table
     * @throws Exception
     */
    public function pairTable(App_Model_Table $table)
    {
        if ($table->pair == App_Model_Table::PAIR_YES) {
            throw new \Exception('table-already-pair', 400);
        }
        $table->pair = App_Model_Table::PAIR_YES;
        $table->save();
    }

    /**
     * @param string $token
     *
     * @return App_Model_Table|null
     * @throws Exception
     */
    public function getTable($token)
    {
        $table = App_Model_Table::fetchOne([
            'token' => $token
        ]);
        if (!$table) {
         throw new Exception('tabl-not-found', 400);
        }
        return $table;
    }

    /**
     * @param string $token
     * @return App_Model_Table|bool
     */
    public function identify($token)
    {
        if (!empty($token)) {

            $table = App_Model_Table::fetchOne([
                'token' => $token
            ]);

            if ($table) {
                return $table;
            }
        }
        return false;
    }
}