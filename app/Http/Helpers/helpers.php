<?php

function generate_token($user){
    $time = microtime();
    $email = $user->email;
    $password = $user->password;
    $token = str_shuffle('token'.$email.$password.'hungrr'.$time);
    $user->auth_token = preg_replace('/\s+/', '', $token);
    $user->save();
    return $user->auth_token;
}

/**
 * @param $startLatitude
 * @param $startLongitude
 * @param $endLatitude
 * @param $endLongitude
 * @return float
 * Calculate distance (in meters) between diferent positions
 */
function distance($startLatitude, $startLongitude, $endLatitude, $endLongitude) {
    $theta = $startLongitude - $endLongitude;
    $distance = sin(deg2rad(floatval($startLatitude))) * sin(deg2rad(floatval($endLatitude))) +
        cos(deg2rad(floatval($startLatitude))) * cos(deg2rad(floatval($endLatitude))) * cos(deg2rad(floatval($theta)));
    $distance = acos($distance);
    $distance = rad2deg($distance);
    $miles = $distance * 60 * 1.1515;
    return ($miles * 1.609344)*1000;
}

/**
 * Delimitates the min/max lat/lng for distance based search
 * Snippet from: http://www.michael-pratt.com/blog/7/Encontrar-Lugares-cercanos-con-MySQL-y-PHP/
 * @param $lat
 * @param $lng
 * @param int $distance
 * @param int $earthRadius
 * @return array
 */
function getConstraints($lat, $lng, $distance = 1000, $earthRadius = 6371)
{
    $constraints = array();
    $cardinalCoords = array(
        'north' => '0',
        'south' => '180',
        'east' => '90',
        'west' => '270');
    $rLat = deg2rad($lat);
    $rLng = deg2rad($lng);
    $rAngDist = (($distance/1000)/$earthRadius);
    foreach ($cardinalCoords as $name => $angle)
    {
        $rAngle = deg2rad($angle);
        $rLatB = asin(sin($rLat) * cos($rAngDist) + cos($rLat) * sin($rAngDist) * cos($rAngle));
        $rLonB = $rLng + atan2(sin($rAngle) * sin($rAngDist) * cos($rLat), cos($rAngDist) - sin($rLat) * sin($rLatB));
        $constraints[$name] = array('lat' => (float) rad2deg($rLatB),
            'lng' => (float) rad2deg($rLonB));
    }
    return
        array(
            'min_lat' => $constraints['south']['lat'],
            'max_lat' => $constraints['north']['lat'],
            'min_lng' => $constraints['west']['lng'],
            'max_lng' => $constraints['east']['lng']);
}