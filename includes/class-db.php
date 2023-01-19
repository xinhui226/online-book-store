<?php

class DB{
    private $db;

    public function __construct(){

        try{
           $this->db = new PDO(
              'mysql:host=devkinsta_db;
              dbname=Online_Book_Store',
              'root',
              'cD4FYhCb9HPk9bc0'
            );
        }catch(PDOException $error){
            die('Database Connection Failed');
        }
        
    }

    public static function connect(){
        return new self();
    }

    public function select($sql,$data=[],$is_list=false){
        $statement = $this->db->prepare($sql);
        $statement->execute($data);

        if($is_list){
            return $statement->fetchAll(PDO::FETCH_ASSOC);
        }else{
            return $statement->fetch(PDO::FETCH_ASSOC);
        }
    }

    public function insert($sql,$data){
        $statement=$this->db->prepare($sql);
        $statement->execute($data);
        return $this->db->lastInsertId();
    }

    public function update($sql,$data=[]){
        $statement = $this->db->prepare($sql);
        $statement->execute($data);
        return $statement->rowCount();
    }

    public function delete($sql,$data=[]){
        $statement = $this->db->prepare($sql);
        $statement->execute($data);
        return $statement->rowCount();
    }
}