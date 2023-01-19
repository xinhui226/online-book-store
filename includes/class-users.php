<?php

class Users{
    
    //get all users
    public static function getAllUsers($limit=null)
    {
        if($limit)
        {
            return DB::connect()->select(
            'SELECT * FROM users ORDER BY id DESC LIMIT '.$limit,
            [],
            true
            );
        }

        return DB::connect()->select(
            'SELECT * FROM users ORDER BY id DESC',
            [],
            true
            );        
    }

    //quantity of users account
    public static function totalUserAccount()
    {
        //fetch
        return DB::connect()->select('SELECT COUNT(id) AS quantity FROM users');
    } 

    //get user by id provided
    public static function getUserById($id)
    {
        return DB::connect()->select(
            'SELECT * FROM users WHERE id=:id',
            [
                'id'=>$id
            ]
        );
    }


    /**
     * add account
     */
    public static function add($username,$email,$role,$password)
    {
        DB::connect()->insert(
            'INSERT INTO users (username,email,role,password) VALUES (:username,:email,:role,:password)',
            [
                'username'=>$username,
                'email'=>$email,
                'role'=>$role,
                'password'=>password_hash($password,PASSWORD_DEFAULT)
            ]
            );
    }

    //delete user
    public static function delete($id)
    {
        return DB::connect()->delete(
            'DELETE FROM users WHERE id=:id',
            [
                'id'=>$id
            ]
            );
    }

    //update user
    public static function update($id,$username,$email,$role,$password=null)
    {
        $params = [
            'id'=>$id,
            'username'=>$username,
            'email'=>$email,
            'role'=>$role,
        ];

        if($password)
        {
            $params['password']=password_hash($password,PASSWORD_DEFAULT);
        }

        return DB::connect()->update(
            'UPDATE users SET username=:username,email=:email,'.($password?'password=:password,':'').'role=:role WHERE id=:id',
            $params
        );
    }
}