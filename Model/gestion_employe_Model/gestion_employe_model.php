<?php

include_once "../database.php";

class Administrateur{
    private $db;

    public function __contruct(){
        $this->db = new myDatabase();
    }

    public function getAllEleve(){
        try{
            $query = "SELECT * FROM administrateur where archive = 0";
            
        }
    }
}