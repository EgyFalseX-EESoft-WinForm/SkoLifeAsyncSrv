<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>Hello World Title</title>
    </head>
    <body>
        <?php
    // Insert the path where you unpacked log4php
    //include_once('log4php/Logger.php');
    // Tell log4php to use our configuration file.
    //Logger::configure('loggingconfiguration.xml');
    // Fetch a logger, it will inherit settings from the root logger
    //$log = Logger::getLogger('index');

    // Start logging
//    $log->trace("My first message.");   // Not logged because TRACE < WARN
//    $log->debug("My second message.");  // Not logged because DEBUG < WARN
//    $log->info("My third message.");    // Not logged because INFO < WARN
//    $log->warn("My fourth message.");   // Logged because WARN >= WARN
//    $log->error("My fifth message.");   // Logged because ERROR >= WARN
//    $log->fatal("My sixth message.");   // Logged because FATAL >= WARN
        ?>
        Hello World!!!
    </body>
</html>
