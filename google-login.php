<?php

$client_id = '77567119740-b04vcpd9g5i2fv9j6mh0ihijfnudurvs.apps.googleusercontent.com';
$redirect_uri = 'http://localhost/sign-up-sign-in-form/google-callback.php';
$scope = 'email profile';
$auth_url = "https://accounts.google.com/o/oauth2/v2/auth?response_type=code&client_id=$client_id&redirect_uri=$redirect_uri&scope=$scope";
header('Location: ' . $auth_url);
exit();
?>