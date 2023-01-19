<?php

if(!Authentication::isLoggedIn())
{
    header('Location: /login');
}//end -if(!Authentication::isLoggedIn())

Authentication::loggedOut();

$_SESSION['message'] = 'Successfully Logout !';
header('Location: /login');
exit;