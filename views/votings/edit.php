<?php
    require_once __DIR__.'/../../utils/session_user_load.php';
    guard(true, true, false);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Редактирование опроса</title>
</head>
<body>
    <?php
        require_once __DIR__.'/../../models/voting.php';
        $voting_id = $_GET['id'];
        if (empty($voting_id)) {
            echo 'Нет id';
        } else {
            $opnedValue = 1;
            $closedValue = 0;
            $voting_id = (int)$voting_id;
            $voting = Voting::getById($db_connection, $voting_id);
            echo '<form action="/nure_practice/handlers/voting/update.php" method="post">';
                echo '<input type="text" name="subject" placeholder="Тема" value="'.strval($voting->subject).'" require><br>';
                echo '<textarea rows="10" cols="45" name="description">'.strval($voting->description).'</textarea><br>';
                echo '<select name="opned">';
                        echo "<option ".($voting->opned === $opnedValue ? 'selected': '')." value=$opnedValue>Открыто</option>";
                        echo "<option ".($voting->opned === $closedValue ? 'selected': '')." value=$closedValue>Закрыто</option>";
                echo '</select><br>';
                echo '<input type="hidden" name="voting_id" value="'.strval($voting_id).'">';
                echo '<input type="submit" value="Обновить">';
            echo '</form>';
        }
    ?>
</body>
</html>