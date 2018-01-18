<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 11/22/17
 * Time: 5:34 AM
 */

class modelDB {

    private $conn;

    function __construct() {
        require_once dirname(__FILE__). 'connectDB.php';
        $db = new connectDB();
        $this->conn = $db->connect();
    }

    function getKomisariat() {
        $sql = "SELECT * FROM komisariat";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $komisariat = $stmt->fetch();
        return $komisariat;
    }
}