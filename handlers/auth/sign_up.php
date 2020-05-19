<?php
    require_once __DIR__.'/../../models/user.php';
    session_start();

    $db_connection = include(__DIR__.'/../../utils/connection.php');

    $newUser = array(
        ':login' => $_POST['login'],
        ':full_name' => $_POST['full_name'],
        ':role' => (int)($_POST['role'] ?? UserRoles::USER),
        ':password' => $_POST['password']
    );

    $user_id = (int)User::register($db_connection, $newUser);
    $user = User::getById($db_connection, $user_id);

    $email = $_POST['email'];

    if (!empty($email)) {
        $user->insertEmail($db_connection, $email);
    }

    var_dump($user)
?>