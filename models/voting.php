<?php

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

        public static function createVotingFromSQLRow($sqlRow) {
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