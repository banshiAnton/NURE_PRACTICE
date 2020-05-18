<?php
    require_once __DIR__.'/../../config/db-config.php';
    $db_connection = include(__DIR__.'/../../utils/connection.php');

    session_start();

    $login = $_POST['login'];
    $password = $_POST['password'];

    $sql = 'SELECT id, role FROM users WHERE login = :login AND password = :password';
    $sth = $db_connection->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
    $sth->execute(array(':login' => $login, ':password' => $password));
    $user = $sth->fetch();

    if ($user) {
        $_SESSION[SESSION_USER_ID_KEY] = $user['id'];
        $_SESSION[SESSION_USER_ROLE_KEY] = $user['role'];
    }

    header('Location: ../../index.php');
?>