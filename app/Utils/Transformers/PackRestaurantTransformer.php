<?php
/**
 * Created by PhpStorm.
 * User: PIX
 * Date: 03/05/2016
 * Time: 11:00 PM
 */
namespace App\Utils\Transformers;


class PackRestaurantTransformer extends RestaurantTransformer
{
    public function transform($restaurant){
        $restaurantTransformed = parent::transform($restaurant);
        $packsTransformed = array();
        foreach($restaurant['packs'] as $pack){
            $packsTransformed[] = $this->transformPack($pack);
        }
        $restaurantTransformed['packs'] = $packsTransformed;
        return $restaurantTransformed;
    }

    private function transformPack($pack){
        $packTransformed = array();
        $packTransformed['name'] = $pack['name'];
        $packTransformed['price'] = $pack['price'];
        $packTransformed['description'] = $pack['description'];

        $elements = array();
        foreach( $pack['elements'] as $element ){
            $elements[] = $this->transformElement($element);
        }
        $packTransformed['elements'] = $elements;
        return $packTransformed;
    }

    private function transformElement($element){
        return array(
            'id' => $element['id'],
            'name' => $element['name'],
            'description' => $element['description'],
            'currency' => $element['currency'],
            'type' => $element['type'],
            'image' => asset($element['image']),
            'price' => $element['price']
        );
    }
}