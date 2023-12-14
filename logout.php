<?php
session_start();
setcookie('fp_hotel_access_token', '', time() - 3600, '/', '', false, true);

$_SESSION =  [];
session_unset();
session_destroy();

if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(
        session_name(),
        '',
        time() - 3600,
        $params["path"],
        $params["domain"],
        $params["secure"],
        $params["httponly"]
    );
}

header("Location: index.php");
exit;

?>