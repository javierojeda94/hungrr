<?php
/**
 * Created by PhpStorm.
 * User: PIX
 * Date: 31/03/2016
 * Time: 08:52 PM
 */

namespace app\Utils\Transformers;

define('SPACE', ' ');
define('FIRST', 0);
header('Content-Type: text/html; charset=utf-8');

class VenueTransformer extends Transformer
{

    public function transform($venue)
    {

        $address = '';
        $addressItems = $venue['location']['formattedAddress'];
        foreach($addressItems as $item){
            $address .= SPACE . $item;
        }

        $imageURL = '';
        $firstCategory = $venue['categories'][FIRST];
        if(isset($firstCategory['icon'])){
            $imageURL = $firstCategory['icon']['prefix'] .  $firstCategory['icon']['suffix'];
        }

        return [
            'id' => $venue['id'],
            'name' => $venue['name'],
            'latitude' => $venue['location']['lat'],
            'longitude' => $venue['location']['lng'],
            'address' => $address,
            'type' =>  $firstCategory['shortName'],
            'image' => $imageURL
        ];
    }
}