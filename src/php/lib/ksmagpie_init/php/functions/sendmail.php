<?php
/**
 * Send an e-mail using PHP's mail() function.
 *
 * This function supports sending an e-mail using PHP's mail()
 * function. 
 * 
 * @warning Make sure your server configuration supports the mail() function.
 * 
 * 
 * You can configure the sendmail server by following the instructions in this video:
 * - Video: https://youtu.be/Fywr8gIVdLY
 * - sendmail : https://github.com/sendmail-tls1-2/main
 * 
 * @note In most cases, you don't need to configure the mail() server. You only need to do this if you're running locally.
 *
 * @param string $expediteur The sender's e-mail address.
 * @param string $recipient The recipient's e-mail address.
 * @param string $subject The subject of the e-mail.
 * @param string $message The message body of the e-mail.
 * 
 * @author Kerogs
 * @return int Returns 1 if the e-mail was sent successfully, otherwise returns 0.
 */ 
function ksmagpie_sendmail($expediteur, $destinataire, $sujet, $message){

    $headers = "Content-Type: text/html; charset=UTF-8\r\n";
    $headers .= "From: $expediteur\r\n";

    if(mail($destinataire, $sujet, $message, $headers))
        return 1;
    else
        return 0;

}