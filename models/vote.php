<?php
    require_once __DIR__.'/../utils/sql_executor.php';
    class VoteChoice {
        const YES = 1;
        const NO = 2;
        const PASS = 3;
    }

    class VoteTableFields {
        const USER_ID = "user_id";
        const CHOICE = "choice";
        const DATE = "date";
        const VOTING_ID = "voting_id";
    }

    class Vote {

        public $user_id;
        public $choice;
        public $date;
        public $voting_id;

        public function __construct() {

        }

        public static function makeVoteByUserId($db_connection, $vote_id, $user_id, $vote_result) {
            $sql = 'INSERT INTO votes(voting_id, choice, user_id) VALUES (:vote_id, :vote_result, :user_id)';
            $params = array(
                ':vote_id' => array('dataType' => PDO::PARAM_INT, 'value' => $vote_id),
                ':vote_result' => array('dataType' => PDO::PARAM_INT, 'value' => $vote_result),
                ':user_id' => array('dataType' => PDO::PARAM_INT, 'value' => $user_id)
            );
            return SQLExecutor::insert($db_connection,  $sql, $params);
        }

        public static function createVoteFromSQLRow($sqlRow) {
            $vote = new Vote();

            $vote->user_id = (int)$sqlRow[VoteTableFields::USER_ID];
            $vote->choice = (int)$sqlRow[VoteTableFields::CHOICE];
            $vote->date = $sqlRow[VoteTableFields::DATE];
            $vote->voting_id = (int)$sqlRow[VoteTableFields::VOTING_ID];

            return $vote;
        }
    }
?>