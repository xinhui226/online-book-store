<?php

class CSRF{
    
    //generate random token
    public static function generateToken($form='')
    {
        if(!isset($_SESSION[$form.'_csrf_token']))
        {
            $_SESSION[$form.'_csrf_token'] = bin2hex(random_bytes(32));
        }
    }

    //verify session token and form token
    public static function verifyToken($formToken,$form)
    {
            if(isset($_SESSION[$form.'_csrf_token'])&&$formToken==$_SESSION[$form.'_csrf_token'])
                return true;

        return false;
    }

    //get token value from session to the form
    public static function getToken($form)
    {
            if(isset($_SESSION[$form.'_csrf_token']))
                return $_SESSION[$form.'_csrf_token'];

        return false;
    }

    //remove session token
    public static function removeToken($form)
    {
        if(isset($_SESSION[$form.'_csrf_token']))
        unset($_SESSION[$form.'_csrf_token']);
    }
}