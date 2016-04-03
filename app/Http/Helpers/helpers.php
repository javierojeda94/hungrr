<?php

function generate_token($email, $password){
    $time = microtime();
    $shuffled_string = str_shuffle('token'.$email.$password.'hungrr'.$time);
    return base64_encode($shuffled_string);
}
