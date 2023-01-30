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
        DB::connect()->insert(
            'INSERT INTO messages (name,email,content) VALUES (:name,:email,:content)',
            [
                'name'=>$name,
                'email'=>$email,
                'content'=>$text
            ]
        );

        $curl = curl_init();
            curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
            curl_setopt($curl, CURLOPT_USERPWD, 'api:'.MAILGUN_API_KEY);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'POST');
            curl_setopt($curl, CURLOPT_URL,MAILGUN_API_URL);
            curl_setopt($curl, CURLOPT_POSTFIELDS,
                array('from' => $name.' <'.$email.'>',
                      'to' => 'name <'.MAILGUN_RECEIVER.'>',
                      'subject' => 'New Message to Online Book Store',
                      'text' => $text ));
            $response = curl_exec($curl);
            $error = curl_error($curl);
            curl_close($curl);

            if($error)
            die ('API not working');

            return json_decode($response);

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