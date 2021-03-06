<?php
    require_once __DIR__.'/../../utils/session_user_load.php';
    guard(false, false, false, false);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SignUp</title>
</head>
<body>
    <form action="/nure_practice/handlers/auth/sign_up.php" method="post">
        <input type="text" name="full_name" placeholder="ФИО" require><br>
        <input type="text" name="login" placeholder="Логин" require><br>
        <input type="email" name="email" placeholder="Почта" require><br>
        <input type="password" name="password" placeholder="Пароль" require><br>
        <?php
            if ($session_user) {
                if ($session_user->isAdmin()) {
                    $adminRoleValue = UserRoles::ADMIN;
                    $secreteryRoleValue = UserRoles::SECRETARY;
                    $userRoleValue = UserRoles::USER;
                    echo '<select name="role">';
                        echo "<option value=$adminRoleValue>Admin</option>";
                        echo "<option value=$secreteryRoleValue>Secretery</option>";
                        echo "<option selected value=$userRoleValue>User</option>";
                    echo '</select><br>';
                }
            }
        ?>
        <input type="submit" value="Зарегистрироваться">
    </form>
    <a href="/nure_practice/views/auth/sign_in.php">Уже есть аккаунт</a>
</body>
</html>