<?php
    require_once __DIR__.'/../../utils/session_user_load.php';
    guard(true, true, false);
    require_once __DIR__.'/../../models/voting.php';

    $voting_id = (int)$_POST['voting_id'];

    $update_value = array(
        ':subject' => $_POST['subject'],
        ':description' => $_POST['description'] ?? '',
        ':opned' => (int) $_POST['opned']
    );

    Voting::updateVotingById($db_connection, $voting_id, $update_value)
?>