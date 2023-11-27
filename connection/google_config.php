<?php
// init configuration
require_once "vendor/autoload.php";
$clientID = '95537069727-l08ujpqn58m5jjsdd64np5k5vn8ofmnu.apps.googleusercontent.com';
$clientSecret = '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';
$redirectUri = 'http://localhost/kelas(11)/SEMESTER-1/PWB/new%20fountaine%20project-hotel/fountaine-project-kelompok09/welcome.php';

// buat request client untuk mengakses API Google
$client = new Google_Client();
$client->setClientId($clientID);
$client->setClientSecret($clientSecret);
$client->setRedirectUri($redirectUri);
$client->addScope("email");
$client->addScope("profile");
?>