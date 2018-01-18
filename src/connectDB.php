<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 11/22/17
 * Time: 5:34 AM
 */

include_once dirname(__FILE__). 'config.php';

class connectDB {

    private $conn;

    function connect() {
        $ok = DBhost;
        $ok1 = DBname;
        $this->conn = new PDO("mysql:host=$ok;dbname=$ok1", DBuser, DBpass);
        $this->conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
        return $this->conn;
    }
}