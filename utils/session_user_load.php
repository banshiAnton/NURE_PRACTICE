<?php
    require_once __DIR__.'/../config/constants.php';
    require_once __DIR__.'/../models/user.php';

    session_start();

    $session_user = null;
    $db_connection = null;

    function __redirect($redirect) {
        if ($redirect) {
            header("Location: /nure_practice/views/auth/sign_in.php");
            die();
        }
    }

    function guard($admin, $secretery, $user, $redirect = true) {
        global $db_connection;
        global $session_user;

        $db_connection = include_once(__DIR__.'/connection.php');

        var_dump($_SESSION[SESSION_USER_ID_KEY]);

        if (!empty($_SESSION[SESSION_USER_ID_KEY])) {
            $session_user = User::getById($db_connection, (int)$_SESSION[SESSION_USER_ID_KEY]);
        }

        if ($admin || $secretery || $user) {
            if (empty($session_user)) {
                __redirect($redirect);
                return;
            }

            if (
                    !(
                        ($user && $session_user->isUser()) ||
                        ($secretery && $session_user->isSecretary()) ||
                        ($admin && $session_user->isAdmin())
                    )
            ) {
                __redirect($redirect);
                return;
            }
        }
    }

    function logOut() {
        global $session_user;
        $session_user = null;
        unset($_SESSION[SESSION_USER_ID_KEY]);
    }
?>