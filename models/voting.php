<?php
    require_once __DIR__.'/../utils/sql_executor.php';
    require_once __DIR__.'/vote.php';

    class VotingTableFields {
        const ID = "id";
        const SUBJECT = "subject";
        const DESCRIPTION = "description";
        const CREATED_DATE = "created_date";
        const OPNED = "opned";
    }

    class Voting {

        const PAGE_LIMIT = 20;

        public $id;
        public $subject;
        public $description;
        public $created_date;
        public $opned;
        public $isVoted;
        public $vote;

        public function __construct() {
            $this->isVoted = false;
        }

        public function isOpned() {
            return $this->opned === 1;
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

        public static function loadVotings($db_connection, $user_id, $page = 1) {
            $limit = self::PAGE_LIMIT;
            $offset = ($page - 1) * $limit;
            $sql = 'SELECT * FROM votings LEFT JOIN votes ON votes.voting_id = votings.id WHERE votes.user_id = :user_id OR votes.user_id IS NULL ORDER BY votings.created_date DESC LIMIT :limit OFFSET :offset';
            $params = array(
                ':limit' => array('dataType' => PDO::PARAM_INT, 'value' => $limit),
                ':offset' => array('dataType' => PDO::PARAM_INT, 'value' => $offset),
                ':user_id' => array('dataType' => PDO::PARAM_INT, 'value' => $user_id)
            );
            $votingRows = SQLExecutor::execute($db_connection,  $sql, $params);
            return array_map(function ($votingRow) {
                $voting =  self::createFromSQLRow($votingRow);
                if (!empty($votingRow[VoteTableFields::VOTING_ID])) {
                    $voting->vote = Vote::createFromSQLRow($votingRow);
                }
                return $voting;
            }, $votingRows);
        }

        public static function countAll($db_connection) {
            $sql = 'SELECT COUNT(*) as votings_count FROM votings';
            $params = array();
            $result = SQLExecutor::execute($db_connection,  $sql, $params);
            return $result['votings_count'];
        }

        public static function createFromSQLRow($sqlRow) {
            $voting = new Voting();

            $voting->id = (int)$sqlRow[VotingTableFields::ID];
            $voting->subject = $sqlRow[VotingTableFields::SUBJECT];
            $voting->description = $sqlRow[VotingTableFields::DESCRIPTION];
            $voting->created_date = $sqlRow[VotingTableFields::CREATED_DATE];
            $voting->opned = (int)$sqlRow[VotingTableFields::OPNED];

            return $voting;
        }
    }
?>