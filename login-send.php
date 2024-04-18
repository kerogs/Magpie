<?php

require_once __DIR__.'/src/php/lib/ksmagpie_init/php/php_ini.php';

$loginUsername = $_POST['username'];
$loginPassword = $_POST['password'];
$loginAccountKey = $_POST['key'];
$loginRegister = $_POST['register'];

if (isset($loginRegister)) {
    $registerToken = ksmagpie_generateToken(8, "nl_", "_" . uniqid());
    ksmagpie_cookieSave("token", $registerToken); 

    $loginPassword = password_hash($loginPassword, PASSWORD_DEFAULT);

    $registerAccountkey = ksmagpie_generateToken(16, "ksinf_");

    $registerData = array(
        "account" => array(
            "token" => $registerToken,
            "admin" => false,
            "premium" => false,
            "username" => $loginUsername,
            "password" => $loginPassword,
            "accountKey" => $registerAccountkey, 
            "accountKeyStatus" => true, 
            "date" => date("Y-m-d H:i:s"),
            "description" => "this user has no description...", 
        ),
        "shop" => array(
            "money" => 0
        ),
        "inventory" => array(
            "badge" => array(
                "b1" => array(
                    "name" => "Little newcomer",
                    "price" => "0",
                    "rarity" => "common-"
                )
            )
        )
    );

    $path = './data/account/' . $registerToken; 
    mkdir($path);

    file_put_contents("$path/user.json", json_encode($registerData), JSON_PRETTY_PRINT);

    header('Location: /');
    exit; 
}

if(isset($loginAccountKey)){
    foreach(scandir('./data/account/') as $account){
        $pathJson = "./data/account/$account/user.json";
        $userJSON = json_decode(file_get_contents($pathJson), true);

        if($loginAccountKey == $userJSON['account']['accountKey'] && $userJSON['account']['accountKeyStatus'] == true){
            ksmagpie_cookieSave("token", $account);
            header('Location: /');
            exit; 
        }
    }
}

if(!isset($loginAccountKey) && !isset($loginRegister)){
    foreach(scandir('./data/account/') as $account){
        $pathJson = "./data/account/$account/user.json";
        $userJSON = json_decode(file_get_contents($pathJson), true);

        if($loginUsername == $userJSON['account']['username'] && password_verify($loginPassword, $userJSON['account']['password'])){
            ksmagpie_cookieSave("token", $account);
            header('Location: /');
            exit; 
        }
    }
}

header('Location: /login/error?m=Wrong information');