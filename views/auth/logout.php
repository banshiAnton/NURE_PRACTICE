<?php
    require_once __DIR__.'/../../config/constants.php';
    session_start();
    session_destroy();
    header("Location: /nure_practice/index.php");
?>