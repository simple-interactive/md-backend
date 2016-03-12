<?php

/**
 * @class App_Service_Statistics
 */
class App_Service_Statistics
{

    public function putIntoStatistics(App_Model_Product $product, App_Model_Order $order, $count)
    {
        $data = $product->asArray();
        unset($data['id']);
        for($i = 0; $i < $count; $i ++) {
            $stproduct = new App_Model_STProduct($data);
            $stproduct->orderId = (string) $order->id;
            $stproduct->productId = (string) $product->id;
            $stproduct->createdAt = new \MongoDate();
            $stproduct->save();
        }

        if (!App_Model_STSection::fetchOne([
            'sectionId' => $product->sectionId
        ])) {
            $stsection = new App_Model_STSection();
            $section = App_Model_Section::fetchOne([
                'id' => new \MongoId($product->sectionId)
            ]);
            $stsection->sectionId = $product->sectionId;
            $stsection->title = $section->title;
            $stsection->parentId = $section->parentId;
            $stsection->save();
        }

        if (isset($product->ingredients) && count($product->ingredients) > 0)
            foreach ($product->ingredients as $ingredient) {
                $ingredient = App_Model_Ingredient::fetchOne([
                    'id' => new \MongoId($ingredient['ingredient']['id'])
                ]);
                $stIngredient = App_Model_STIngredient::fetchOne([
                    'ingredientId' => (string) $ingredient->id
                ]);
                if (!$stIngredient) {
                    $stIngredient = new App_Model_STIngredient([
                        'ingredientId' => (string) $ingredient->id,
                        'title' => $ingredient->title
                    ]);
                    $stIngredient->save();
                }
            }

    }
}