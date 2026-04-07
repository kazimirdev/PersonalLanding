<?php

abstract class DatabaseModel {

    protected PDO $db;

    public function __construct() {
        $this->db = DB::connect();
    }
}

?>