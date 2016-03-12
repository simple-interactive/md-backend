<?php

/**
 * @class App_Map_Product
 */
class App_Map_Product extends Mongostar_Map_Instance
{
    public function rulesCommon()
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
    public function rulesOrder()
    {
        return [
            'id' => 'id',
            'partOfSection' => 'section',
            'title' => 'title',
            'description' => 'description',
            'options' => 'options',
            'ingredients' => 'ingredients',
            'price' => 'price',
            'weight' => 'weight'
        ];
    }

    /**
     * @param App_Model_Product $product
     * s
     * @return array
     */
    public function getPartOfSection(App_Model_Product $product)
    {
        $section = App_Model_Section::fetchOne(['id' => $product->sectionId]);
        if (!$section) {
            return null;
        }
        return [
            'title' => $section->title,
            'id' => (string)$section->id
        ];
    }
} 