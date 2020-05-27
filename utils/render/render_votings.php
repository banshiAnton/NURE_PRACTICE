<?php
    require_once __DIR__.'/../../models/voting.php';
    require_once __DIR__.'/../../models/vote.php';
    function render_votings($votings, $forEdit) {
        global $session_user;
        foreach($votings as $voting) {
            $id = $voting->id;
            $isAbleToVote = $voting->isOpned() && empty($voting->vote);
            $state = $voting->isOpned() ? 'Открыто' : 'Закрыто';
            $votesYes = $voting->votes[VoteChoice::YES];
            $votesNo = $voting->votes[VoteChoice::NO];
            $votesPass = $voting->votes[VoteChoice::PASS];
            if ($forEdit || !$isAbleToVote) {
                if ($forEdit) {
                    echo '<a class="disable" href="/nure_practice/views/votings/edit.php?id='.$id.'">';
                }
                echo '<div>';
                    echo "Тема: <b>{$voting->subject}</b><br>";
                    echo "Дата: <b>{$voting->created_date}</b><br>";
                    echo "Статус: <b>{$state}</b><br>";
                    echo "Описание: <p>{$voting->description}</p>";
                    if (!$voting->hasVotes) {
                        echo 'Еще нет голосов<br>';
                    } else {
                        echo "За: {$votesYes}<br>";
                        echo "Против: {$votesNo}<br>";
                        echo "Воздержался: {$votesPass}<br>";
                    }
                    if (!$forEdit) {
                        if(!empty($voting->vote)) {
                            $youeChoice = $voting->vote->choice;
                            $youeChoiceText = $youeChoice == VoteChoice::YES ? 'За' : $youeChoice == VoteChoice::NO ? 'Против' : 'Воздержаться';
                            echo "Ваш выбор: <b>{$youeChoiceText}</b><br>";
                            echo "Дата выбора: <b>{$voting->vote->date}</b><br>";
                        } else {
                            echo "Ваш выбор: <b>[Отсутствует]</b><br>";
                        }
                    }
                echo '</div><br><br><br>';
                if ($forEdit) {
                    echo '</a>';
                }
            } else {
                echo '<form action="/nure_practice/handlers/voting/vote.php" method="POST">';
                    echo "Тема: <b>{$voting->subject}</b><br>";
                    echo "Дата: <b>{$voting->created_date}</b><br>";
                    echo "Статус: <b>{$state}</b><br>";
                    echo "Описание: <p>{$voting->description}</p>";
                    if (!$voting->hasVotes) {
                        echo 'Еще нет голосов<br>';
                    } else {
                        echo "За: {$votesYes}<br>";
                        echo "Против: {$votesNo}<br>";
                        echo "Воздержался: {$votesPass}<br>";
                    }
                    echo '<lable>';
                        echo '<input type="radio" name="vote_result" value='.strval(VoteChoice::YES).'>';
                    echo 'За</lable>';
                    echo '<lable>';
                        echo '<input type="radio" name="vote_result" value='.strval(VoteChoice::NO).'>';
                    echo 'Против</lable>';
                    echo '<lable>';
                        echo '<input type="radio" name="vote_result" value='.strval(VoteChoice::PASS).'>';
                    echo 'Воздержаться</lable><br>';
                    echo '<input type="hidden" name="voting_id" value="'.strval($voting->id).'">';
                    echo '<input type="submit" value="Проголосовать"></input>';
                echo '</form><br><br><br>';
            }
        }
    }
?>