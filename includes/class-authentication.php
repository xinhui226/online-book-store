<?php

class Authentication
{

    //sign up
    public static function signup($username,$email,$password)
    {
        return DB::connect()->insert(
            'INSERT INTO users (username,email,password)
                    VALUES (:username,:email,:password)',
            [
                'username'=>$username,
                'email'=>$email,
                'password'=>password_hash($password,PASSWORD_DEFAULT)
            ]
        );
    }

    //log in
    public static function login($email,$password)
    {
        $userid = false;
        $user = DB::connect()->select(
            'SELECT * FROM users WHERE email = :email',
            [
                'email'=>$email
            ]
            );

        if($user)
        {
            if(password_verify($password,$user['password']))
            {
                $userid = $user['id'];
            }// end if password_verify
        }// end if $user

        return $userid;
    }

    //set user session
    public static function setSession($userid)
    {
        $user = DB::connect()->select(
            'SELECT * FROM users WHERE id = :id',
            [
                'id'=>$userid
            ]
            );

        $_SESSION['user']=
        [
            'id'=>$user['id'],
            'username'=>$user['username'],
            'email'=>$user['email'],
            'role'=>$user['role'],
        ];
    }

    //check if is user log in
    public static function isLoggedIn(){
    return isset($_SESSION['user']);
    }
  
    //log out
    public static function loggedOut(){
        unset($_SESSION['user']);
    }

    //check user role
    public static function getRole()
    {
        if(self::isLoggedIn())
        {
            return $_SESSION['user']['role'];
        }

        return false;
    }

    //check if user is admin
    public static function isAdmin()
    {
        return self::getRole()=='admin';
    }

    //check if user is editor
    public static function isEditor()
    {
        return self::getRole()=='editor';
    }

    //check if user is user
    public static function isUser()
    {
        return self::getRole()=='user';
    }

    //accessibility
    public static function whoCanAccess($role)
    {
            if(self::isLoggedIn())
            {
                switch($role){
                    case 'admin':
                        return self::isAdmin();
                    case 'editor':
                        return self::isAdmin()||self::isEditor();
                    case 'user':
                        return self::isAdmin()||self::isEditor()||self::isUser();
                    case 'useronly':
                        return self::isUser();
                }
            }

        return false;
    }
}