<?php
    require_once __DIR__.'/../../models/voting.php';
    require_once __DIR__.'/../../models/vote.php';
    function render_votings_to_edit($votings) {
        foreach($votings as $voting) {
            $state = $voting->isOpned() ? 'Открыто' : 'Закрыто';
            $votesYes = $voting->votes[VoteChoice::YES];
            $votesNo = $voting->votes[VoteChoice::NO];
            $votesPass = $voting->votes[VoteChoice::PASS];
            echo '<div>';
                echo "Тема: <b>{$voting->subject}</b><br>";
                echo "Дата: <b>{$voting->created_date}</b><br>";
                echo "Статус: <b>{$state}</b><br>";
                echo "Описание: <p>{$voting->description}</p>";
                if (!$voting->hasVotes) {
                    echo 'Еще нет голосов';
                } else {
                    echo "За: {$votesYes}<br>";
                    echo "Против: {$votesNo}<br>";
                    echo "Воздержался: {$votesPass}<br>";
                }
            echo '</div><br><br><br>';
        }
    }
?>