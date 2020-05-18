<?php
    require_once __DIR__.'/../../config/db-config.php';
    require_once __DIR__.'/../../models/user.php';
    $db_connection = include(__DIR__.'/../../utils/connection.php');

    session_start();

    $login = $_POST['login'];
    $password = $_POST['password'];

    $sql = 'SELECT * FROM users WHERE login = :login AND password = :password';
    $sth = $db_connection->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
    $sth->execute(array(':login' => $login, ':password' => $password));
    $rawUser = $sth->fetch();

    if ($rawUser) {
        $user = User::createUserFromSQLRow($rawUser);
        $_SESSION[SESSION_USER_ID_KEY] = $user->$id;
        $_SESSION[SESSION_USER_ROLE_KEY] = $user->$role;
    }

    header('Location: ../../index.php');
?>