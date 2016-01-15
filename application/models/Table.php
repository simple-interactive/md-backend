<?php
/**
 * @class App_Model_Table
 *
 * @property MongoId $id
 * @property string  $name
 * @property string  $token
 * @property string  $pair
 * @property string  $status
 * @property bool    $isWaitingForWaiter
 *
 * @method static App_Model_Table [] fetchAll(array $cond = null, array $sort = null, $count = null, $offset = null, $hint = NULL)
 * @method static App_Model_Table|null fetchOne(array $cond = null, array $sort = null)
 * @method static App_Model_Table fetchObject(array $cond = null, array $sort = null)
 */
class App_Model_Table extends Mongostar_Model
{
    const PAIR_YES = 'yes';
    const PAIR_NO  = 'no';

    const STATUS_ACTIVE = 'active';
    const STATUS_LOCK = 'lock';
}