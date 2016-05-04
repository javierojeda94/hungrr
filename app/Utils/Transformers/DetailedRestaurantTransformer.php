<?php
/**
 * Created by PhpStorm.
 * User: PIX
 * Date: 21/04/2016
 * Time: 03:18 PM
 */

namespace App\Utils\Transformers;


class DetailedRestaurantTransformer extends RestaurantTransformer
{
    public function transform($restaurant){
        $restaurantTransformed = parent::transform($restaurant);
        $menus = array();
        foreach($restaurant->menus as $menu){
            $menus[] = $this->transformMenu($menu);
        }
        $restaurantTransformed['menus'] = $menus;
        return $restaurantTransformed;
    }

    private function transformMenu($menu){
        $menuTransformed = array();
        $menuTransformed['id'] = $menu['id'];
        $menuTransformed['name'] = $menu['name'];

        $sections = array();
        foreach($menu->sections as $section){
            $sections[] = $this->transformSection($section);
        }
        $menuTransformed['sections'] = $sections;
        return $menuTransformed;
    }

    private function transformSection($section){
        $sectionTransformed = array();
        $sectionTransformed['id'] = $section['id'];
        $sectionTransformed['name'] = $section['name'];

        $elements = array();
        foreach($section->elements as $element){
            $elements[] = $this->transformElement($element);
        }
        $sectionTransformed['elements'] = $elements;
        return $sectionTransformed;
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