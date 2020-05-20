<?php
    require_once __DIR__.'/../../config/constants.php';
    session_start();
    unset($_SESSION[SESSION_USER_ID_KEY]);
    header("Location: /nure_practice/index.php");
?>