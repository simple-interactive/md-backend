<?php
/**
 * @class App_Model_Order
 *
 * @property MongoId $id
 * @property array   $data
 * @property integer $createdDate
 * @property string  $status
 * @property string  $payStatus
 * @property string  $tableId
 * @property string  $isPushed
 *
 * @method static App_Model_Order[] fetchAll(array $cond = null, array $sort = null, $count = null, $offset = null, $hint = NULL)
 * @method static App_Model_Order|null fetchOne(array $cond = null, array $sort = null)
 * @method static App_Model_Order fetchObject(array $cond = null, array $sort = null)
 */
class App_Model_Order extends Mongostar_Model
{
    const STATUS_NEW = 'new';
    const STATUS_SUCCESS= 'success';

    const PAY_STATUS_NO = 'no';
    const PAY_STATUS_YES = 'yes';

    const PUSH_STATUS_NO = 'no';
    const PUSH_STATUS_YES = 'yes';
}