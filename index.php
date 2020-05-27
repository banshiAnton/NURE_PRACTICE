<?php
    require_once __DIR__.'/utils/session_user_load.php';
    guard(true, true, true);
    header("Location: views/main.php");
?>