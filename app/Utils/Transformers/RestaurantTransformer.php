<?php
/**
 * Created by PhpStorm.
 * User: PIX
 * Date: 24/03/2016
 * Time: 01:23 AM
 */

namespace App\Utils\Transformers;
use App\Utils\Transformer;

class RestaurantTransformer extends Transformer
{

    public function transform($restaurant)
    {
        return [
            'id' => $restaurant['id'],
            'name' => $restaurant['name'],
            'latitude' => $restaurant['latitude'],
            'longitude' => $restaurant['longitude'],
            'address' => $restaurant['direction'],
            'type' => $restaurant['type'],
            'image' => $restaurant['image']
        ];

    }
}