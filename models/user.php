<?php
    require_once __DIR__.'/../utils/sql_executor.php';
    class UserRoles {
        const ADMIN = 3;
        const SECRETARY = 2;
        const USER = 1;
    }

    class UserTableFields {
        const ID = "id";
        const FULL_NAME = "full_name";
        const ROLE = "role";
        const LOGIN = "login";
        const PASSWORD = "password";
    }

    class User {

        public $id;
        public $login;
        public $full_name;
        public $role;
        public $emails;

        public function __construct() {
            $this->emails = array();
        }

        public function addEmails($emails) {
           $this->emails = array_merge($this->emails, $emails);
        }

        public function isUser() {
            return $this->role === UserRoles::USER;
        }

        public function isAdmin() {
            return $this->role === UserRoles::ADMIN;
        }

        public function isAbleToAdminVotings() {
            return $this->isAdmin() || $this->isSecretary();
        }

        public function isSecretary() {
            return $this->role === UserRoles::SECRETARY;
        }

        public function isAbleToVote() {
            return $this->isUser() || $this->isSecretary();
        }

        public function loadEmails($db_connection) {
            $sql = 'SELECT email FROM emails WHERE user_id = :user_id';
            $params = array(':user_id' => $this->id);
            $user_emails = SQLExecutor::execute($db_connection,  $sql, $params);
            $user_emails = array_map(function($row) { return $row['email'];}, $user_emails);
            $this->addEmails($user_emails);
        }

        public function insertEmail($db_connection, $email) {
            $sql = 'INSERT INTO emails(email, user_id) VALUES (:email, :user_id)';
            $params = array(':email' => $email, ':user_id' => $this->id);
            SQLExecutor::insert($db_connection, $sql, $params);
            $this->addEmails(array($email));
        }

        public static function getById($db_connection, $id) {
            $sql = 'SELECT * FROM users WHERE id = :id';
            $params = array(':id' => $id);
            $users = SQLExecutor::execute($db_connection,  $sql, $params);
            if (count($users) < 1) {
                return false;
            }
            return self::createFromSQLRow($users[0]);
        }

        public static function authUserByLogin($db_connection, $login, $password) {
            $sql = 'SELECT * FROM users WHERE login = :login AND password = :password';
            $params = array(':login' => $login, ':password' => $password);
            $users = SQLExecutor::execute($db_connection,  $sql, $params);
            if (count($users) < 1) {
                return false;
            }
            return self::createFromSQLRow($users[0]);
        }

        public static function register($db_connection, $fields) {
            $sql = 'INSERT INTO users(full_name, role, login, password) VALUES (:full_name, :role, :login, :password)';
            $user_id = SQLExecutor::insert($db_connection, $sql, $fields);
            return $user_id;
        }

        public static function createFromSQLRow($sqlRow) {
            $user = new User();
            $user->id = (int)$sqlRow[UserTableFields::ID];
            $user->login = $sqlRow[UserTableFields::LOGIN];
            $user->full_name = $sqlRow[UserTableFields::FULL_NAME];
            $user->role = (int)$sqlRow[UserTableFields::ROLE];
            return $user;
        }
    }
?>