<?php
    require_once __DIR__.'/../../utils/session_user_load.php';
    guard(false, false, false, false);

    $login = $_POST['login'];
    $password = $_POST['password'];

    $user = User::authUserByLogin($db_connection, $login, $password);

    if ($user) {
        $user->loadEmails($db_connection);
        $_SESSION[SESSION_USER_ID_KEY] = $user->id;
    }

    header('Location: ../../index.php');
?>