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

    public function __construct()
    {
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
        foreach ($products as $item) {
            if ( $this->_isChanged($item, $item['id'], 'Product') ) {
                $product = App_Model_Product::fetchOne(['id' => $item['id']]);
                if (!$product) {
                    $product = new App_Model_Product();
                }
                $product->id = new MongoId($item ['id']);
                $product->sectionId = $item ['sectionId'];
                $product->description = $item ['description'];
                $product->title = $item ['title'];
                $product->price = $item ['price'];
                $product->options = $item ['options'];
                $product->weight = $item ['weight'];
                $product->images = $item ['images'];
                $product->exists = $item ['exists'];
                $product->save();
            }
        }
    }

    /**
     * @param array $dataSection
     */
    private function _uploadSections(array $dataSection)
    {
        foreach ($dataSection as $item) {
            if ( $this->_isChanged($item, $item['id'], 'Section') ) {
                $section = App_Model_Section::fetchOne(['id' => $item['id']]);
                if (!$section) {
                    $section = new App_Model_Section();
                }
                $section->id = new MongoId($item['id']);

                $section->image = $item['image'];
                if (!empty($item['parentId']))
                    $section->parentId = $item['parentId'];
                $section->image = $item['image'];
                $section->title = $item['title'];
                $section->save();
            }
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