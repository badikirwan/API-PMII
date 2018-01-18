<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 11/21/17
 * Time: 1:12 AM
 */

define('DBhost', 'localhost');
define('DBuser', 'root');
define('DBpass', 'ge223800');
define('DBname', 'db_pmii');

function getDB() {
    $dbhost="localhost";
    $dbuser="root";
    $dbpass="ge223800";
    $dbname="db_pmii";
    $dbConnection =	new	PDO("mysql:host=$dbhost;dbname=$dbname", $dbuser, $dbpass);
    $dbConnection->setAttribute(PDO::ATTR_ERRMODE,	PDO::ERRMODE_EXCEPTION);
    return	$dbConnection;
}