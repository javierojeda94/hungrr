<?php

function generate_token($user){
    $time = microtime();
    $email = $user->email;
    $password = $user->password;
    $user->auth_token = str_shuffle('token'.$email.$password.'hungrr'.$time);
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
    $distance = sin(deg2rad($startLatitude)) * sin(deg2rad($endLatitude)) +
        cos(deg2rad($startLatitude)) * cos(deg2rad($endLatitude)) * cos(deg2rad($theta));
    $distance = acos($distance);
    $distance = rad2deg($distance);
    $miles = $distance * 60 * 1.1515;
    return ($miles * 1.609344)*1000;
}
