<?php
/**
 * @class App_Model_Table
 *
 * @property MongoId $id
 * @property string  $name
 * @property string  $token
 * @property integer $status
 *
 * @method static App_Model_Table [] fetchAll(array $cond = null, array $sort = null, $count = null, $offset = null, $hint = NULL)
 * @method static App_Model_Table|null fetchOne(array $cond = null, array $sort = null)
 * @method static App_Model_Table fetchObject(array $cond = null, array $sort = null)
 */
class App_Model_Table extends Mongostar_Model
{
    const STATUS_WORK = 0;
    const STATUS_DISABLED = 1;
}