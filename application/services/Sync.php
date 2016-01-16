<?php

/**
 * @class App_Service_Sync
 */
class App_Service_Sync {

    const CRM_GET_ALL_DATA = 'mdapi/';
    const HEADER_XAUTH = 'x-auth';

    /**
     * @var App_Helper_Log
     */
    private $_log;

    /**
     * @var string
     */
    private $_host;

    public function __construct($host)
    {
        $this->_host = $host;
        $this->_log = new App_Helper_Log();
    }
    /**
     * @param string $url
     * @param string $token
     */
    public function uploadChanges($url, $token)
    {
        $client = new Zend_Http_Client($url.self::CRM_GET_ALL_DATA);
        $client->setHeaders('x-auth', $token);
        $response = $client->request(Zend_Http_Client::GET);

        if ($response->getStatus() == 200) {
            $data = json_decode($response->getBody(), true);
            $this->_updateProduct($data['products']);
            $this->_uploadSections($data['sections']);
            $this->_uploadStyle($data['style']);
        }
        else {
            $this->_log->err('Can\'t auth in crm [code='.$response->getStatus().', body='.$response->getBody().']');
        }
    }

    /**
     * @param array $products
     */
    private function _updateProduct(array $products){

        if ( empty($products) || count($products) == 0) {
            $products = App_Model_Product::fetchAll();
            /**
             * @var App_Model_Product $product
             */
            foreach($products as $product) {
                App_Model_Section::remove([
                    'id' => (string) $product->id
                ]);
            }
            return;
        };

        $ids = [];
        foreach ($products as $item) {
            $ids [] = $item ['id'];
            if ( $this->_isChanged($item, $item['id'], 'Product') ) {
                $product = App_Model_Product::fetchOne(['id' => $item['id']]);
                if (!$product) {
                    $product = new App_Model_Product();
                }
                if ( $this->_isChanged($item['images'], $item['id'], 'ProductImages') ) {
                    if ( ! empty($product->images)) {
                        $this->_removeImages($product->images);
                    }
                    $i = 0;
                    foreach ($item['images'] as &$image) {
                        $client = new Zend_Http_Client($image['url']);
                        $result = $client->request('GET');
                        $name = $item ['id'] . '-' . $i ++;
                        file_put_contents(APPLICATION_PATH.'/../public/images/'.$name, $result->getBody());
                        $image['name'] = $name;
                        $image['url'] = $this->_host.'/images/'.$name;
                    }
                    $product->images = $item ['images'];
                }
                $product->id = new MongoId($item ['id']);
                $product->sectionId = $item ['sectionId'];
                $product->description = $item ['description'];
                $product->title = $item ['title'];
                $product->price = $item ['price'];
                $product->options = $item ['options'];
                $product->weight = $item ['weight'];
                $product->exists = $item ['exists'];
                $product->save();
            }
        }

        if (count($ids) != 0) {
            App_Model_Product::remove([
                'id' => ['$nin' => $ids]
            ]);
        }
    }

    /**
     * @param array $images
     */
    private function _removeImages($images)
    {
        foreach ($images as $image) {
            unlink(APPLICATION_PATH.'/../public/images/'.$image['name']);
        }
    }

    /**
     * @param array $dataSection
     */
    private function _uploadSections(array $dataSection)
    {
        if ( empty($dataSection) || count($dataSection) == 0) {
            $sections = App_Model_Section::fetchAll();
            /**
             * @var App_Model_Section $section
             */
            foreach($sections as $section) {
                App_Model_Section::remove([
                    'id' => (string) $section->id
                ]);
            }
            return;
        };
        $ids = [];
        foreach ($dataSection as &$item) {
            $ids [] = $item['id'];
            if ( $this->_isChanged($item, $item['id'], 'Section') ) {
                $section = App_Model_Section::fetchOne(['id' => $item['id']]);
                if (!$section) {
                    $section = new App_Model_Section();
                }
                if ( $this->_isChanged($item['image'], $item['id'], 'SectionImage') ) {
                    if ( ! empty($section->image)) {
                        $this->_removeImages([$section->image]);
                    }
                    $client = new Zend_Http_Client($item['image']['url']);
                    $result = $client->request('GET');
                    file_put_contents(APPLICATION_PATH.'/../public/images/'.$item['id'], $result->getBody());
                    $item['image']['url'] = $this->_host.'/images/'.$item['id'];
                    $item['image']['name'] = $item['id'];
                    $section->image =  $item['image'];
                }
                $section->id = new MongoId($item['id']);
                if (!empty($item['parentId']))
                    $section->parentId = $item['parentId'];
                $section->title = $item['title'];
                $section->save();
            }
        }

        if (count($ids) != 0) {
            App_Model_Section::remove([
                'id' => ['$nin' => $ids]
            ]);
        }
    }

    /**
     * @param array $data
     */
    private function _uploadStyle(array $data)
    {
        if ($this->_isChanged($data, $data['id'], 'Style')) {
            $style = App_Model_Style::fetchOne(['id' => $data['id']]);
            if (!$style) {
                $style = new App_Model_Style();
            }
            $style->id = new MongoId($data['id']);
            $style->colors = $data['colors'];
            $style->backgroundImage = $data['backgroundImage'];
            $style->company =  $data['company'];
            $style->save();

        }
    }

    /**
     * @param array $data
     * @param string $id
     * @param string $type
     * @return bool
     */
    private function _isChanged(array $data, $id, $type)
    {
        $changes = App_Model_Changes::fetchOne([
            'refId' => $id,
            'type' => $type
        ]);
        if ($changes && $changes->data == md5(print_r($data, true))) {
            return false;
        }
        else {
            $changes = new App_Model_Changes();
        }

        $changes->data = md5(print_r($data, true));
        $changes->refId = $id;
        $changes->type = $type;
        $changes->save();
        return true;
    }

} 