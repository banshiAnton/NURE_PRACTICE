<?php
    class SQLExecutor {
        public static function execute($db_connection, $sqlQuery, $params) {
            $sth = $db_connection->prepare($sqlQuery, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
            if (is_array($params)) {
                $sth->execute($params);
            }
            $result = $sth->fetchAll();
            return $result;
        }

        public static function insert($db_connection, $sqlQuery, $params) {
            $sth = $db_connection->prepare($sqlQuery, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
            $sth->execute($params);
            return $db_connection->lastInsertId();
        }
    }
?>