<?php

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
            $this->$emails = array();
        }

        public function addEmails($emails) {
           $this->$emails = array_merge($this->$emails, $emails);
        }

        public function isUser() {
            return $this->$role === UserRoles::USER;
        }

        public function isAdmin() {
            return $this->$role === UserRoles::ADMIN;
        }

        public function isSecretary() {
            return $this->$role === UserRoles::SECRETARY;
        }

        public function isAbleToVote() {
            return $this->isUser() || $this->isSecretary();
        }

        public static function createUserFromSQLRow($sqlRow) {
            $user = new User();
            var_dump($sqlRow);
            $user->$id = (int)$sqlRow[UserTableFields::ID];
            $user->$login = $sqlRow[UserTableFields::LOGIN];
            $user->$full_name = $sqlRow[UserTableFields::FULL_NAME];
            $user->$role = (int)$sqlRow[UserTableFields::ROLE];

            return $user;
        }
    }
?>