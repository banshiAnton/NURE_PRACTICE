<?php
    require_once __DIR__.'/../../models/voting.php';
    session_start();

    $db_connection = include(__DIR__.'/../../utils/connection.php');

    $newVoting = array(
        ':subject' => $_POST['subject'],
        ':description' => $_POST['full_name'] ?? '',
    );

    $voting_id = (int)Voting::register($db_connection, $newVoting);
    var_dump($voting_id);
    $voting = Voting::getById($db_connection, $voting_id);
    var_dump($voting)
?>