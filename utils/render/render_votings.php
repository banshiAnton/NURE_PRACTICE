<?php
    require_once __DIR__.'/../../models/voting.php';
    require_once __DIR__.'/../../models/vote.php';
    function render_votings($votings) {
        global $session_user;
        foreach($votings as $voting) {
            $isAbleToVote = $voting->isOpned() && empty($voting->vote);
            $state = $voting->isOpned() ? 'Открыто' : 'Закрыто';
            if (!$isAbleToVote) {
                echo '<div>';
                    echo "Тема: <b>{$voting->subject}</b><br>";
                    echo "Дата: <b>{$voting->created_date}</b><br>";
                    echo "Статус: <b>{$state}</b><br>";
                    echo "Описание: <p>{$voting->description}</p>";
                    if(!empty($voting->vote)) {
                        $youeChoice = $voting->vote->choice;
                        $youeChoiceText = $youeChoice == VoteChoice::YES ? 'За' : $youeChoice == VoteChoice::NO ? 'Против' : 'Воздержаться';
                        echo "Ваш выбор: <b>{$youeChoiceText}</b><br>";
                        echo "Дата выбора: <b>{$voting->vote->date}</b><br>";
                    } else {
                        echo "Ваш выбор: <b>[Отсутствует]</b><br>";
                    }
                echo '</div><br><br><br>';
            } else {
                echo '<form action="/nure_practice/handlers/voting/vote.php" method="POST">';
                    echo "Тема: <b>{$voting->subject}</b><br>";
                    echo "Дата: <b>{$voting->created_date}</b><br>";
                    echo "Статус: <b>{$state}</b><br>";
                    echo "Описание: <p>{$voting->description}</p>";
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