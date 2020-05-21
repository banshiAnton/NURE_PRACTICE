<?php
    require_once __DIR__.'/../../utils/session_user_load.php';
    guard(true, true, false);
    require_once __DIR__.'/../../models/voting.php';

    $newVoting = array(
        ':subject' => $_POST['subject'],
        ':description' => $_POST['full_name'] ?? '',
    );

    $voting_id = (int)Voting::register($db_connection, $newVoting);
    $voting = Voting::getById($db_connection, $voting_id);
?>