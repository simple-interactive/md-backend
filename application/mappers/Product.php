<?php

/**
 * @class App_Map_Product
 */
class App_Map_Product extends Mongostar_Map_Instance
{
    public static function rulesCommon()
    {
        return [
            'id' => 'id',
            'sectionId' => 'section',
            'title' => 'title',
            'description' => 'description',
            'options' => 'options',
            'price' => 'price',
            'weight' => 'weight',
            'images' => 'images',
            'exists' => 'exists'
        ];
    }

    /**
     * @param App_Model_Product $product
     * s
     * @return array
     */
    public function getSectionId(App_Model_Product $product)
    {
        $section = App_Model_Section::fetchOne(['id' => $product->sectionId]);
        return [
            'title' => $section->title,
            'id' => (string)$section->id

        ];
    }
} 