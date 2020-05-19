<?php
    require_once __DIR__.'/../utils/sql_executor.php';
    class VotingResult {
        const YES = 1;
        const NO = 2;
        const DRAW = 3;
    }

    class VotingTableFields {
        const ID = "id";
        const SUBJECT = "subject";
        const DESCRIPTION = "description";
        const CREATED_DATE = "created_date";
        const OPNED = "opned";
    }

    class Voting {

        public $id;
        public $subject;
        public $description;
        public $created_date;
        public $opned;

        public function __construct() {

        }

        public function isOpned() {
            $this->opned === 1;
        }

        public static function getById($db_connection, $id) {
            $sql = 'SELECT * FROM votings WHERE id = :id';
            $params = array(':id' => $id);
            $votings = SQLExecutor::execute($db_connection,  $sql, $params);
            if (count($votings) < 1) {
                return false;
            }
            return self::createFromSQLRow($votings[0]);
        }

        public static function register($db_connection, $fields) {
            $sql = 'INSERT INTO votings(subject, description) VALUES (:subject, :description)';
            $voting_id = SQLExecutor::insert($db_connection, $sql, $fields);
            return $voting_id;
        }

        public static function createFromSQLRow($sqlRow) {
            $voting = new Voting();

            $voting->id = (int)$sqlRow[VotingTableFields::ID];
            $voting->subject = $sqlRow[VotingTableFields::SUBJECT];
            $voting->description = $sqlRow[VotingTableFields::DESCRIPTION];
            $voting->created_date = $sqlRow[VotingTableFields::CREATED_DATE];
            $voting->id = (int)$sqlRow[VotingTableFields::OPNED];

            return $voting;
        }
    }
?>