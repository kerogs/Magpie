<?php
// ! Please do not change this function.
/**
    *   @brief Returns ksmagpie version information.
    *   
    *   @author Kerogs
    *   @return array
 */
function ksmagpie_version()
{
    $name = 'ksmagpie';
    $version = '1.1.2-beta';
    $by = 'Kerogs';
    $groupe = 'Kerogs Infinite';

    return array($name, $version, $by, $groupe);
}

// ? to make the file work, please import this file first
// ! Command to be used in all files that will use ksmagpie :
// * include './php/lib/ksmagpie_ini.php';
// or
// * include __DIR__'./php/lib/ksmagpie_ini.php';



// change the path 
// Default : __DIR__
$path = __DIR__;

// ? List of called functions.

include $path . '/functions/sendmail.php';
include $path . '/functions/discord.php';
include $path . '/functions/ksmagpie_format.php';
include $path . '/functions/function_help.php';
