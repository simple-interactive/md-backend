<?php
/**
 * @class App_Model_Order
 *
 * @property MongoId $id
 * @property array   $data
 * @property integer $createdDate
 * @property string  $status
 * @property string  $payStatus
 * @property string  $paymentMethod
 * @property string  $tableId
 * @property string  $isPushed
 * @property string  $price
 *
 * @method static App_Model_Order[] fetchAll(array $cond = null, array $sort = null, $count = null, $offset = null, $hint = NULL)
 * @method static App_Model_Order|null fetchOne(array $cond = null, array $sort = null)
 * @method static App_Model_Order fetchObject(array $cond = null, array $sort = null)
 */
class App_Model_Order extends Mongostar_Model
{
    const STATUS_NEW = 'new';
    const STATUS_SUCCESS = 'success';
    const STATUS_CANCELED = 'canceled';

    const PAYMENT_METHOD_CASH = 'cash';
    const PAYMENT_METHOD_CARD = 'card';

    const PAY_STATUS_NO = 'no';
    const PAY_STATUS_YES = 'yes';

    const PUSH_STATUS_NO = 'no';
    const PUSH_STATUS_YES = 'yes';
}