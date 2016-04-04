<?php

function generate_token($user){
    $time = microtime();
    $email = $user->email;
    $password = $user->password;
    $user->auth_token = str_shuffle('token'.$email.$password.'hungrr'.$time);
    $user->save();
    return $user->auth_token;
}
