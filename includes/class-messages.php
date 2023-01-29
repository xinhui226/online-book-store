<?php

class Messages{

    //get all message
    public static function listAllMessage()
    {
        //fetchall
        return DB::connect()->select(
            'SELECT * FROM messages ORDER BY id DESC',
            [],
            true);
    }

     //quantity of status (pending)'s message
     public static function allMessage()
     {
        //fetch
         return DB::connect()->select('SELECT COUNT(id) AS quantity FROM messages');
     } 


    //send message
    public static function sendMessage($name,$email,$text)
    {

       return DB::connect()->insert(
            'INSERT INTO messages (name,email,content) VALUES (:name,:email,:content)',
            [
                'name'=>$name,
                'email'=>$email,
                'content'=>$text
            ]
        );

        // return 'We will get right back to you !';
    }

    //search
    public static function search($message)
    {
        return DB::connect()->select(
            'SELECT * FROM messages WHERE CONCAT(id,name,email,content,created_at) LIKE "%'.$message.'%"',
            [],
            true
            );
        
    }


    //delete message
    public static function deleteMessage($id)
    {
         return  DB::connect()->delete(
            'DELETE FROM messages WHERE id = :id',
                [
                'id'=>$id
                ]
            );
        
            // return 'Successfully delete message!';
    }
}