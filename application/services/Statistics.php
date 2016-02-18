<?php

/**
 * @class App_Service_Statistics
 */
class App_Service_Statistics
{

    public function getOrders(
        $timeStart,
        $timeEnd,
        $offset = 0,
        $count = 10,
        App_Model_Section $section = null,
        $status,
        $paymentMethod
    )
    {
        if ($timeStart >= $timeEnd) {
            throw new \Exception('time-invalid', 400);
        }

        $cond = [
            'createdDate' => [
                '$gte' => (int) $timeStart,
                '$lte' => (int) $timeEnd
            ]
        ];

        if ($section) {
            $ids = $this->_getSectionIds([], (string) $section->id);
            $cond ['data.product.section.id'] = [
                '$in' => $ids
            ];
        }

        if ($status) {
            $cond['status'] = $status;
        }

        if ($paymentMethod) {
            $cond['paymentMethod'] = $paymentMethod;
        }
        
        $orders = App_Model_Order::fetchAll(
            $cond,
            [
                'createdDate' => 1
            ],
            (int) $count,
            (int) $offset
        );
        return $orders;
    }

    public function getCountOrders(
        $timeStart,
        $timeEnd
    )
    {
        return $orders = App_Model_Order::getCount([
            'createdDate' => [
                '$gte' => (int) $timeStart,
                '$lte' => (int) $timeEnd
            ]
        ]);
    }

    private function _getSectionIds(array $ids, $sectionId)
    {
        $ids [] = $sectionId;

        $sections = App_Model_Section::fetchAll([
                'parentId' => $sectionId
        ]);

        if ( ! $sections) {
            return $ids;
        }

        foreach ($sections as $section) {
            $ids = $this->_getSectionIds($ids, (string) $section->id);
        }

        return $ids;
    }

}