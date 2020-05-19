<?php
    require_once __DIR__.'/../../config/constants.php';
    require_once __DIR__.'/../../models/user.php';

    $db_connection = include(__DIR__.'/../../utils/connection.php');

    session_start();

    unset($_SESSION[SESSION_USER_ID_KEY]);
    unset($_SESSION[SESSION_USER_ROLE_KEY]);

    $login = $_POST['login'];
    $password = $_POST['password'];

    $user = User::authUserByLogin($db_connection, $login, $password);

    if ($user) {
        $user->loadEmails($db_connection);
        $_SESSION[SESSION_USER_ID_KEY] = $user->id;
        $_SESSION[SESSION_USER_ROLE_KEY] = $user->role;
    }

    header('Location: ../../index.php');
?>