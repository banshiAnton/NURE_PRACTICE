<?php
    require_once __DIR__.'/../utils/sql_executor.php';
    require_once __DIR__.'/../models/user.php';
    class UserORM {
        public static function getUserById($db_connection, $id) {
            $sql = 'SELECT * FROM users WHERE id = :id';
            $params = array(':id' => $id);
            $users = SQLExecutor::execute($db_connection,  $sql, $params);
            if (count($users) < 1) {
                return false;
            }
            return User::createUserFromSQLRow($users[0]);
        }

        public static function authUserByLogin($db_connection, $login, $password) {
            $sql = 'SELECT * FROM users WHERE login = :login AND password = :password';
            $params = array(':login' => $login, ':password' => $password);
            $users = SQLExecutor::execute($db_connection,  $sql, $params);
            if (count($users) < 1) {
                return false;
            }
            return User::createUserFromSQLRow($users[0]);
        }
    }
?>