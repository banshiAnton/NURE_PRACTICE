<?php
    require_once __DIR__.'/../utils/session_user_load.php';
    guard(true, true, true);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Main</title>
</head>
<body>
    <?php
        var_dump($session_user)
    ?>
    <?php
        if ($session_user->isAbleToVote()) {
            echo '<br><a href="/nure_practice/views/votings/list.php">Опросы</a>';
        }
        if ($session_user->isAbleToAdminVotings()) {
            echo '<br><a href="/nure_practice/views/votings/list.php?edit=1">Управление опросам</a>';
        }
    ?>
    <br><a href="/nure_practice/views/auth/logout.php">Выход</a>
</body>
</html>