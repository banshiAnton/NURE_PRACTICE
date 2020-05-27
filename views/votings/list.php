<?php
    require_once __DIR__.'/../../utils/session_user_load.php';
    $is_edit_page = array_key_exists('edit', $_GET);
    $prever_admin = $is_edit_page ? true: false;
    $prever_user = $is_edit_page ? false : true;
    guard($prever_admin, true, $prever_user);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Опросы</title>
    <style>
        .disable { 
            text-decoration: none;
            color: black;
            cursor: pointer;
        }

        .pages {
            padding: 20px
        }
    </style>
</head>
<body>
    <?php
        require_once __DIR__.'/../../models/voting.php';
        require_once __DIR__.'/../../utils/render/render_votings.php';

        if ($is_edit_page) {
            echo '<a href="/nure_practice/views/votings/register.php">Создать новый опрос</a><br><br><br>';
        }

        $page = (int)($_GET['page'] ?? 1);
        $votings = Voting::loadVotings($db_connection, $is_edit_page ? null : $session_user->id, $page);
        // var_dump($votings);
        render_votings($votings, $is_edit_page);

        $count_of_votings = Voting::countAll($db_connection);
        $current_count = ($page - 1) * Voting::PAGE_LIMIT + count($votings);
        if ($page > 1) {
            $prev_page = $page - 1;
            echo '<a class="disable pages" href="/nure_practice/views/votings/list.php?page='.strval($prev_page).strval($is_edit_page ? '&edit=1' : '').'"><<<< Назад</a>';
        }
        if ($count_of_votings > $current_count) {
            $next_page = $page + 1;
            echo '<a class="disable pages" href="/nure_practice/views/votings/list.php?page='.strval($next_page).strval($is_edit_page ? '&edit=1' : '').'">Вперед >>>></a>';
        }
    ?>
</body>
</html>