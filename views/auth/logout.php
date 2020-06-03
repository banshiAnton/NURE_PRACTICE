<?php
    require_once __DIR__.'/../../utils/session_user_load.php';
    logOut();
    session_destroy();
    header("Location: /nure_practice/index.php");
?>