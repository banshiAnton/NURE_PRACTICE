<?php
    require_once __DIR__.'/../../utils/session_user_load.php';
    guard(true, true, true);

    require_once __DIR__.'/../../models/vote.php';

    $vote_result = (int)($_POST['vote_result'] ?? VoteChoice::PASS);
    $vote_id = (int)$_POST['voting_id'];

    $row_id = Vote::makeVoteByUserId($db_connection, $vote_id, $session_user->id, $vote_result);

    var_dump($row_id);
?>