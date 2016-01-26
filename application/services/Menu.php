<?php

class App_Service_Menu
{

    /**
     * @param string $sectionId
     *
     * @return App_Model_Section|false
     * @throws Exception
     */
    public function getSection($sectionId)
    {
        $section = App_Model_Section::fetchOne([
            'id' => $sectionId
        ]);

        if (!$section) {
            throw new Exception('section-not-found', 400);
        }

        return $section;
    }

    /**
     * @param string $parentId
     *
     * @return App_Model_Section[]
     * @throws Exception
     */
    public function getSectionList($parentId = null)
    {
        return App_Model_Section::fetchAll([
            'parentId' => $parentId
        ]);
    }

    /**
     * @param App_Model_Section $section
     * @param array $ids
     *
     * @return integer[]
     */
    private function _getTreeOfSection(App_Model_Section $section, array $ids = [])
    {
        $parentId = (string)$section->id;
        $ids [] = $parentId;

        $childSections = App_Model_Section::fetchAll([
            'parentId' => $parentId
        ]);

        foreach ($childSections as $child) {
            $ids = $this->_getTreeOfSection($child, $ids);
        }

        return $ids;
    }

    /**
     * @param int $offset
     * @param int $count
     * @param bool $onlyExists
     *
     * @return App_Model_Product[]
     */
    public function getProductList($offset = 0, $count = 10, $onlyExists = false)
    {
        $cond = [];
        if ($onlyExists) {
            $cond ['exists'] = true;
        }
        return App_Model_Product::fetchAll($cond, null, (int)$count, (int)$offset);
    }

    public function getProductCount($onlyExists = false)
    {
        $cond = [];
        if ($onlyExists) {
            $cond ['exists'] = true;
        }
        return App_Model_Product::getCount();
    }
    /**
     * @param App_Model_Section $section
     * @param int $offset
     * @param int $count
     *
     * @return App_Model_Product[]
     * @throws Exception
     */
    public function getProductListBySection(
        App_Model_Section
        $section,
        $offset = 0,
        $count = 10
    )
    {
        return App_Model_Product::fetchAll([
            'sectionId' => (string) $section->id
        ], null, (int)$count, (int)$offset);
    }

    /**
     * @param App_Model_User $user
     * @param string $search
     * @param int $offset
     * @param int $count
     *
     * @return App_Model_Product[]
     * @throws Exception
     */
//    public function getProductListBySearch(App_Model_User $user, $search, $offset = 0, $count = 10)
//    {
//        if (!$search) {
//            throw new Exception('search-invalid', 400);
//        }
//        $models = App_Model_Search::fetchAll([
//            'data' => new MongoRegex("/$search/i")
//        ]);
//        $ids = [];
//        foreach ($models as $item) {
//                $ids [] = $item->productId;
//        }
//        return App_Model_Product::fetchAll([
//            'userId' => (string) $user->id,
//            'id' => ['$in' => $ids]
//        ], null, (int)$count, (int)$offset);
//    }

    /**
     * @param App_Model_Section $section
     *
     * @return int
     * @throws Exception
     */
    public function getProductCountBySection(App_Model_Section $section)
    {
        return App_Model_Product::getCount([
            'sectionId' => (string) $section->id
        ]);
    }

    /**
     * @param App_Model_User $user
     * @param $search
     *
     * @return int
     * @throws Exception
     */
//    public function getProductCountBySearch(App_Model_User $user, $search)
//    {
//        if (!$search) {
//            throw new Exception('search-invalid', 400);
//        }
//        $models = App_Model_Search::fetchAll([
//            'data' => new MongoRegex("/$search/i")
//        ]);
//        $ids = [];
//        foreach ($models as $item) {
//            $ids [] = $item->productId;
//        }
//        return App_Model_Product::getCount([
//            'userId' => (string) $user->id,
//            'id' => ['$in' => $ids]
//        ]);
//    }

    /**
     * @param string $productId
     *
     * @return App_Model_Product|null
     * @throws Exception
     */
    public function getProduct($productId)
    {
        $product = App_Model_Product::fetchOne(['id' => $productId]);
        if (!$product) {
            throw new Exception('not-found', 400);
        }
        return $product;
    }

    /**
     * @return array
     */
    public function treeSections()
    {
        $models = App_Model_Section::fetchAll();
        $modelsArray = [];
        $res = [];
        foreach ($models as $model) {
            $res [(string) $model->id] = [];
            $modelsArray [(string)$model->id] = $model;
        }
        foreach($models as $model) {
            $res[$model->parentId][] = $model;
        }
        $toPrint = [
            "sections" => []
        ];

        foreach($models as $model){
            if ( count($res[(string)$model->id]) == 0){
                if(empty($model->parentId)){
                    $toPrint ['sections'] [(string)$model->id] = [
                        'id' => (string) $model->id,
                        'title' => $model->title
                    ];
                    continue;
                }
                if(empty( $toPrint ['sections'] [$model->parentId]))
                    $toPrint ['sections'] [$model->parentId] = [
                        'id' => (string) $modelsArray [$model->parentId]->id,
                        'title' => $modelsArray [$model->parentId]->title,
                        'sub-sections' =>  [[
                            'id' => (string) $model->id,
                            'title' => $model->title
                        ]]
                    ];
                else {
                    $toPrint ['sections'] [$model->parentId] ['sub-sections'] [] = [
                        'id' => (string) $model->id,
                        'title' => $model->title
                    ];
                }
            }
        }

        $i = 0;
        foreach(array_keys($toPrint['sections']) as $item){
            $toPrint ['sections'] [$i++] = $toPrint['sections'] [$item];
            unset($toPrint['sections'] [$item]);
        }

        return $toPrint['sections'];
    }

    /**
     * @param $productId
     * @param bool $exists
     *
     * @throws Exception
     */
    public function setProductExists($productId, $exists)
    {
        $product = App_Model_Product::fetchOne([
            'id' => $productId
        ]);
        if (!$productId) {
           throw new \Exception('product-not-found');
        }
        $product->exists = $exists;
        $product->save();
    }
} 