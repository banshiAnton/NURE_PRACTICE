<?php
    require_once __DIR__.'/../config/constants.php';
    session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Main</title>
</head>
<body>
    Main
    <?php
        var_dump($_SESSION[SESSION_USER_ID_KEY], $_SESSION[SESSION_USER_ROLE_KEY]);
    ?>
</body>
</html>