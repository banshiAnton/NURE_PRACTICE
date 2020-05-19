<?php

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