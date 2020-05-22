<?php
    class SQLExecutor {
        public static function execute($db_connection, $sqlQuery, $params) {
            $sth = $db_connection->prepare($sqlQuery, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
            if (is_array($params)) {
                foreach($params as $param_name => $param_value) {
                    if (is_array($param_value)) {
                        $sth->bindParam($param_name, $param_value['value'], $param_value['dataType']);
                    } else {
                        $sth->bindValue($param_name, $param_value);
                    }
                }
            }
            $sth->execute();
            $result = $sth->fetchAll();
            return $result;
        }

        public static function insert($db_connection, $sqlQuery, $params) {
            $sth = $db_connection->prepare($sqlQuery, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
            if (is_array($params)) {
                foreach($params as $param_name => $param_value) {
                    if (is_array($param_value)) {
                        $sth->bindParam($param_name, $param_value['value'], $param_value['dataType']);
                    } else {
                        $sth->bindValue($param_name, $param_value);
                    }
                }
            }
            $sth->execute();
            return $db_connection->lastInsertId();
        }
    }
?>