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
define('DEFAULT_TYPE', 'Restaurant');
define('IMAGE_DEFAULT_PATH', 'images/restaurants/sample_restaurant.png');
/**
 * Sizes can take this values on both width and heigth 36, 100, 300, or 500 plus it can be just original size
 * https://developer.foursquare.com/docs/responses/photo
 */

define('SIZE', 'original');

header('Content-Type: text/html; charset=utf-8');

class VenueTransformer extends Transformer
{

    public function transform($venue)
    {
        return [
            'id' => $venue['id'],
            'name' => $venue['name'],
            'latitude' => $venue['location']['lat'],
            'longitude' => $venue['location']['lng'],
            'address' => $this->getAddress($venue),
            'type' =>  $this->getType($venue),
            'image' => $this->getImageURL($venue)
        ];
    }

    private function getType($venue){
        if(isset($venue['categories'])){
            $type = $venue['categories'][FIRST]['shortName'];
        }else{
            $type = DEFAULT_TYPE;
        }
        return $type;
    }

    private function getImageURL($venue){
        $photosNumber = $venue['photos']['count'];
        if( $photosNumber > 0 ){
            $firstPhoto = $venue['photos']['groups'][FIRST]['items'][FIRST];
            $imageURL = $firstPhoto['prefix'] . SIZE . $firstPhoto['suffix'];
        }else{
            $imageURL = asset(IMAGE_DEFAULT_PATH);
        }
        return $imageURL;
    }

    private function getAddress($venue){
        $address = '';
        $addressItems = $venue['location']['formattedAddress'];
        foreach($addressItems as $item){
            $address .= SPACE . $item;
        }
        return $address;
    }
}