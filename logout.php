<?php
session_start();
setcookie('fp_hotel_access_token', '', time() - 3600, '/', '', false, true);

$_SESSION =  [];
session_unset();
session_destroy();

header("Location: index.php");
exit;

?>