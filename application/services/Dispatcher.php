<?php

/**
 * @class App_Service_Dispatcher
 */
class App_Service_Dispatcher
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
     * @param $token
     * @return bool
     *
     * @throws Zend_Exception
     */
    public function checkToken($token)
    {
        $config = Zend_Registry::get('config');
        return $config['dispatcher']['token'] === $token;
    }

    public function pairTable(App_Model_Table $table)
    {
        if ($table->pair == App_Model_Table::PAIR_YES) {
            throw new \Exception('table-already-pair');
        }
        $table->pair = App_Model_Table::PAIR_YES;
        $table->save();
    }
}