<?php

ini_set('display_errors', 'Off');
error_reporting(E_ALL & ~E_NOTICE);
// ini_set('log_errors', 'On');

$token = $_COOKIE['token'];

// $serverJSON = file_get_contents(json_decode('./data/serverconfig.json'), true);
// && $serverJSON['server']['forceLogin']

// TODO make forceLogin works
if (!isset($token)){
    header('location: ./login/register');
    exit;
} else {
    // ! Please do not change this.
    require_once __DIR__ . '/lib/ksmagpie_init/php/php_ini.php';
    require_once __DIR__ . '/functions.php';
    require_once 'vendor/autoload.php';

    $accountPath = "./data/account/$token/user.json";
    $accountPathUrl = "./data/account/$token";
    $accountJSON = json_decode(file_get_contents($accountPath), true);

    // check for account json
    if (!isset($accountJSON)) {
        header('location: ./login/register');
        exit;
    }

    // ? account
    $userName = htmlentities($accountJSON['account']['username']);
    $userToken = $accountJSON['account']['token'];
    $userAdminStatus = $accountJSON['account']['admin'];
    $userPremiumStatus = $accountJSON['account']['premium'];
    $description = htmlentities($accountJSON['account']['description']);
    
    // ? role
    if ($userAdminStatus) {
        $userRole = 'Admin';
    } else if ($userPremiumStatus) {
        $userRole = 'Premium';
    } else {
        $userRole = 'User';
    }

    // ? badge list
    foreach ($accountJSON['inventory']['badge'] as $key => $value) {
        $badgeList[$key] = $value;
    }

    $money = $accountJSON['shop']['money'];

    // ? user pfp
    ksmagpie_foundExtension("$accountPathUrl/pfp") ? $userPfp = "$accountPathUrl/".ksmagpie_foundExtension("$accountPathUrl/pfp") : $userPfp = "./src/img/userbase/pfp.png";
    // ? user banner
    ksmagpie_foundExtension("$accountPathUrl/banner") ? $userBanner = "$accountPathUrl/".ksmagpie_foundExtension("$accountPathUrl/banner") : $userBanner = "./src/img/userbase/banner.png";

    // ? website file (/data/serverconfig.json)
    $websitePath = "./data/serverconfig.json";
    $websiteJSON = json_decode(file_get_contents($websitePath), true);
    $websiteVersion = $websiteJSON['version']['version'];
}