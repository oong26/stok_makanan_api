<?php

$serverName = "DESKTOP-C7BEDHI";
$uid = "admin";
$pwd = "26122000";
$databaseName = "kantin_db"; 

$connectionInfo = array( "UID"=>$uid,
                         "PWD"=>$pwd,
                         "Database"=>$databaseName); 

$conn = sqlsrv_connect( $serverName, $connectionInfo);
