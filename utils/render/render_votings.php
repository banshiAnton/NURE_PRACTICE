<?php
    require_once __DIR__.'/../../models/voting.php';
    require_once __DIR__.'/../../models/vote.php';
    function render_votings($votings) {
        global $session_user;
        foreach($votings as $voting) {
            $state = $voting->isOpned() ? 'Открыто' : 'Закрыто';
            // var_dump($voting);
            echo '<form action="/nure_practice/handlers/voting/vote.php" method="POST">';
                echo "<b>{$voting->subject}</b><br>";
                echo "<b>{$voting->created_date}</b><br>";
                echo "<b>{$state}</b><br>";
                echo "<p>{$voting->description}</p><br>";
                echo '<lable>';
                    echo '<input type="radio" name="vote_result" value='.strval(VotingResult::YES).'>';
                echo 'За</lable>';
                echo '<lable>';
                    echo '<input type="radio" name="vote_result" value='.strval(VotingResult::NO).'>';
                echo 'Против</lable>';
                echo '<lable>';
                    echo '<input type="radio" name="vote_result" value='.strval(VotingResult::DRAW).'>';
                echo 'Воздержаться</lable><br>';
                echo '<input type="hidden" name="voting_id" value="'.strval($voting->id).'">';
                echo '<input type="hidden" name="user_id" value="'.strval($session_user->id).'">';
                echo '<input type="submit" value="Проголосовать"></input>';
            echo '</form><br><br>';
        }
    }
?>