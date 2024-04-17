<?php

if(!$_COOKIE['mgp_token']){
    header('Location: login.php');
    break;
}

session_start();

// TODO login page
// TODO Register page
// TODO Design

// ? user var
$userToken = $_COOKIE['mgp_token'];
$userPath = "data/account/$userToken/";
$userJSON = json_decode(file_get_contents("$userPath/user.json"), true);