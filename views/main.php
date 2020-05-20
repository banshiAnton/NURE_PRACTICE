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
    <br><a href="/nure_practice/views/auth/logout.php">Выход</a>
</body>
</html>