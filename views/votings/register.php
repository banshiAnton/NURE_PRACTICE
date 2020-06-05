<?php
    require_once __DIR__.'/../../utils/session_user_load.php';
    guard(true, true, false);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Создание опроса</title>
</head>
<body>
    <form action="/nure_practice/handlers/voting/register.php" method="post">
        <input type="text" name="subject" placeholder="Тема" require><br>
        <textarea rows="10" cols="45" name="description"></textarea><br>
        <input type="submit" value="Создать">
    </form>
</body>
</html>