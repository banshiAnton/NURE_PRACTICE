<?php
    require_once __DIR__.'/../../utils/session_user_load.php';
    guard(true, true, true);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php
        require_once __DIR__.'/../../models/voting.php';
        require_once __DIR__.'/../../utils/render/render_votings.php';

        $page = $_GET['page'] ?? 1;
        $votings = Voting::loadVotings($db_connection, $page);
        render_votings($votings);
    ?>
</body>
</html>