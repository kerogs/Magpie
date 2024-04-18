<?php

/**
 * Send a message via a Webhook.
 *
 * This function supports sending a message to a Webhook Discord
 * using the POST method with JSON content. It uses cURL to
 * make the request.
 *
 * @param string $name     The username to be displayed in the message.
 * @param string $message  The content of the message to be sent.
 * @param string $token    Webhook Discord link.
 * 
 * @author Kerogs
 * @return string  The response to the cURL request.
 */ 
function ksmagpie_webhooks($name, $message, $token){

    $headers = [ 'Content-Type: application/json; charset=utf-8' ];
    $POST = [ 'username' => $name, 'content' => $message ];

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $token);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($POST));
    $response   = curl_exec($ch);

    return $response;
}