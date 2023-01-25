<?php

class FormValidation
{

    //check email valid or not
    public static function isEmailExist($email)
    {
        $email = DB::connect()->select(
            'SELECT * FROM users WHERE email =:email',
            [
                'email'=>$email
            ]
            );

        if($email)
        {
            return 'Email is already exist.';
        }
    return false;
    }

    //check category name valid or not
    public static function isCategoryExist($name)
    {
         $category = DB::connect()->select(
             'SELECT * FROM categories WHERE name = :name',
             [
                 'name'=>$name
             ]
             );
         if($category)
         {
             return 'Category "'.$name.'" is already exist.';
         }
 
         return false;
    }


     //check product image valid or not
     public static function checkImageValid($filename)
     {
            if(empty($filename['name']))
            {
                return 'The "image" field is empty<br>';
            } 
            elseif(filesize($filename["tmp_name"]) <= 0)
            {
                return 'The file of '.$key.' is empty<br>';
            } 
            elseif(!exif_imagetype($filename["tmp_name"])){
                return  "Only image allowed<br>"; 
            }
        return false;
     }


    public static function validation($data,$rules=[])
    {
        $error = false;

        foreach($rules as $key => $condition)
        {
            switch($condition)
            {
               case 'required' :
                    if(empty($data[$key])) $error.= 'The field "'.$key.'" is empty<br>';
                    break;

                case 'text' :
                    if(empty($data[$key])) $error.= 'The field "'.$key.'" is empty<br>';
                    elseif (!preg_match("/^[a-zA-Z ]*$/",$data[$key]))  $error .= 'Only alphabets and white space are allowed for "'.$key.'"<br>';  
                    elseif(strlen($data[$key])<3) $error.= 'Please enter at least 3 characters for "'.$key.'"<br>';
                    break;

                case 'numeric' :
                    if(empty($data[$key])) $error.= 'The field "'.$key.'" is empty<br>';
                    elseif (!is_numeric($data[$key])) $error .= 'Only numeric value is allowed for field "'.$key.'"<br>';  
                    break;

                case 'phone' :
                    if(empty($data[$key])) $error.= 'The field "'.$key.'" is empty<br>';
                    elseif (!preg_match('/^[0-9]{3}-[0-9]{7,8}$/', $data[$key])) $error .= 'Invalid phone number format. <br>';  
                    break;

                case 'password_check' :
                    if(empty($data[$key])) $error .= 'The field "'. $key . '" is empty<br>';
                    elseif(strlen($data[$key])<8) $error.='Password should be at least 8 characters<br>';
                    break;

                case 'is_password_match' :
                    if($data['password']!=$data['confirm_password']) $error.= 'Password and Confirm password is not match<br>';
                    break;

                case 'email_check' :
                    if(empty($data[$key])) $error.='The field "'.$key.'" is empty<br>';
                    elseif(!filter_var($data[$key],FILTER_VALIDATE_EMAIL)) $error .='Invalid email format .<br>';
                    break;

                // check token
                case 'login_form_token' :
                    if(!CSRF::verifyToken($data[$key],'login_form')) die ('Nice Try');
                    break;

                case 'signup_form_token' :
                    if(!CSRF::verifyToken($data[$key],'signup_form')) die ('Nice Try');
                    break;

                case 'contact_form_token' :
                    if(!CSRF::verifyToken($data[$key],'contact_form')) die ('Nice Try');
                    break;

                case 'edit_author_token' :
                    if(!CSRF::verifyToken($data[$key],'edit_author')) die ('Nice Try');
                    break;

                case 'add_author_token' :
                    if(!CSRF::verifyToken($data[$key],'add_author')) die ('Nice Try');
                    break;

                case 'delete_author_token' :
                    if(!CSRF::verifyToken($data[$key],'delete_author')) die ('Nice Try');
                    break;

                case 'edit_category_token' :
                    if(!CSRF::verifyToken($data[$key],'edit_category')) die ('Nice Try');
                    break;

                case 'add_category_token' :
                    if(!CSRF::verifyToken($data[$key],'add_category')) die ('Nice Try');
                    break;

                case 'delete_category_token' :
                    if(!CSRF::verifyToken($data[$key],'delete_category')) die ('Nice Try');
                    break;

                case 'edit_message_token' :
                    if(!CSRF::verifyToken($data[$key],'edit_message')) die ('Nice Try');
                    break;

                case 'delete_message_token' :
                    if(!CSRF::verifyToken($data[$key],'delete_message')) die ('Nice Try');
                    break;

                case 'add_product_token' :
                    if(!CSRF::verifyToken($data[$key],'add_product')) die ('Nice Try');
                    break;

                case 'edit_product_token' :
                    if(!CSRF::verifyToken($data[$key],'edit_product')) die ('Nice Try');
                    break;

                case 'delete_product_token' :
                    if(!CSRF::verifyToken($data[$key],'delete_product')) die ('Nice Try');
                    break;

                case 'add_account_token' :
                    if(!CSRF::verifyToken($data[$key],'add_account')) die ('Nice Try');
                    break;

                case 'edit_account_token' :
                    if(!CSRF::verifyToken($data[$key],'edit_account')) die ('Nice Try');
                    break;

                case 'delete_account_token' :
                    if(!CSRF::verifyToken($data[$key],'delete_account')) die ('Nice Try');
                    break;

                case 'add_cart_token' :
                    if(!CSRF::verifyToken($data[$key],'add_cart_item')) die ('Nice Try');
                    break;

                case 'delete_cart_token' :
                    if(!CSRF::verifyToken($data[$key],'delete_cart_item')) die ('Nice Try');
                    break;

                case 'increase_cart_token' :
                    if(!CSRF::verifyToken($data[$key],'increase_cart_item')) die ('Nice Try');
                    break;

                case 'decrease_cart_token' :
                    if(!CSRF::verifyToken($data[$key],'decrease_cart_item')) die ('Nice Try');
                    break;

                case 'checkout_form_csrf_token' :
                    if(!CSRF::verifyToken($data[$key],'checkout_form')) die ('Nice Try');
                    break;
                     // Veri important harr xD (ok !)             ^ liddat code more clean not meh
                case 'update_orderstatus_token' :
                    if(!CSRF::verifyToken($data[$key],'update_orderstatus')) die ('Nice Try');
                    break;

            } //end - switch
        } //end - foreach($rules)

        return $error;
    } //end - function validation
}