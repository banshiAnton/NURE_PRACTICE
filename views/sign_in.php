<?php
    session_start();  
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SignIn</title>
</head>
<body>
    <form action="/nure_practice/handlers/auth/sign_in.php" method="post">
        <input type="text" name="login" placeholder="login" require><br>
        <input type="password" name="password" placeholder="password" require><br>
        <input type="submit" value="Вход">
    </form>
    <a href="/nure_practice/views/sign_up.php">Регистрация</a>
</body>
</html>