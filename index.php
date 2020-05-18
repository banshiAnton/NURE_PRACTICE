<?php
    require_once __DIR__.'/config/constants.php';
    session_start();
    if (empty($_SESSION[SESSION_USER_ID_KEY])) {
        header("Location: views/sign_in.php");
    } else {
        header("Location: views/main.php");
    }
?>