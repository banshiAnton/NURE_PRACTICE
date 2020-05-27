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

        const PAGE_LIMIT = 2;

        public $id;
        public $subject;
        public $description;
        public $created_date;
        public $opned;
        public $vote;
        public $votes;
        public $hasVotes;

        public function __construct() {
            $this->hasVotes = false;
            $this->votes = array(
                VoteChoice::YES => 0,
                VoteChoice::NO => 0,
                VoteChoice::PASS => 0
            );
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
            $params = array(
                ':limit' => array('dataType' => PDO::PARAM_INT, 'value' => $limit),
                ':offset' => array('dataType' => PDO::PARAM_INT, 'value' => $offset),
            );
            $sql = 'SELECT * FROM votings ORDER BY votings.created_date DESC LIMIT :limit OFFSET :offset';
            $votingRows = SQLExecutor::execute($db_connection,  $sql, $params);
            $votings = array_map(function ($votingRow) {
                $voting =  self::createFromSQLRow($votingRow);
                return $voting;
            }, $votingRows);

            $voting_ids = array_map(function($voting){return $voting->id;}, $votings);
            $votings_with_votes = self::loadVotingsWithVotes($db_connection, $voting_ids, $user_id);
            foreach($votings as $voting) {
                $voting->vote =  $votings_with_votes[$voting->id]->vote;
                $voting->votes = $votings_with_votes[$voting->id]->votes;
                $voting->hasVotes = $votings_with_votes[$voting->id]->hasVotes;
            }
            return $votings;
        }

        public static function loadVotingsWithVotes($db_connection, $votings_ids, $user_id) {
            $params = array();
            if (!empty($user_id)) {
                $params[':user_id'] = array('dataType' => PDO::PARAM_INT, 'value' => $user_id);
            }
            $in_concat = "";
            foreach ($votings_ids as $i => $value)
            {
                $param_name = ":votings_id".$i;
                $in_concat .= "$param_name,";
                $params[$param_name] = array('dataType' => PDO::PARAM_INT, 'value' => $value);
            }
            $in_concat = rtrim($in_concat, ",");
            $sql = "";
            if (empty($user_id)) {
                $sql = "SELECT votings.*, votes.*, COUNT(votes.voting_id) as votes_count FROM votings LEFT JOIN votes ON votes.voting_id = votings.id WHERE votings.id IN ($in_concat) GROUP BY votings.id, votes.choice ORDER BY votings.created_date DESC";
            } else {
                $sql = "SELECT votings.*, votes.*, COUNT(votes.voting_id) as votes_count, BIT_OR(:user_id = votes.user_id) as is_user_voted FROM votings LEFT JOIN votes ON votes.voting_id = votings.id WHERE votings.id IN ($in_concat) GROUP BY votings.id, votes.choice ORDER BY votings.created_date DESC";
            }
            $votingRowsJoined = SQLExecutor::execute($db_connection,  $sql, $params);
            return self::proccessOnJoinVotinsAndVotes($votingRowsJoined);
        }

        public static function proccessOnJoinVotinsAndVotes($votingRowsJoined) {
            return array_reduce($votingRowsJoined, function ($votingsStore, $votingRow) {
                $voting =  self::createFromSQLRow($votingRow);
                $voteType = $votingRow[VoteTableFields::CHOICE];
                $voteCount = (int)$votingRow['votes_count'];
                $is_user_voted = !array_key_exists('is_user_voted', $votingRow) ? 0 : (int)$votingRow['is_user_voted'];
                if ($is_user_voted === 1) {
                    $voting->vote = Vote::createFromSQLRow($votingRow);
                }
                if (!array_key_exists($voting->id, $votingsStore)) {
                    $votingsStore[$voting->id] = $voting;
                }
                if ($voteCount === 0) {
                    $voting->hasVotes = false;
                } else {
                    $voting->hasVotes = true;
                    $votingsStore[$voting->id]->votes[$voteType] += $voteCount;
                    $votingsStore[$voting->id]->hasVotes = $voting->hasVotes;
                    if (empty($votingsStore[$voting->id]->vote)) {
                        $votingsStore[$voting->id]->vote = $voting->vote;
                    }
                }
                return $votingsStore;
            }, array());
        }

        public static function countAll($db_connection) {
            $sql = 'SELECT COUNT(id) as votings_count FROM votings';
            $params = array();
            $result = SQLExecutor::execute($db_connection,  $sql, $params);
            return (int)$result[0]['votings_count'];
        }

        public static function updateVotingById($db_connection, $voting_id, $params) {
            $sql = 'UPDATE votings SET subject = :subject, description = :description, opned = :opned';
            return SQLExecutor::insert($db_connection,  $sql, $params);
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