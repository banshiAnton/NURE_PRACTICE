<?php
    class SQLExecutor {
        public static function execute($db_connection, $sqlQuery, $params) {
            return self::_executor($db_connection, $sqlQuery, $params, false);
        }

        public static function insert($db_connection, $sqlQuery, $params) {
            return self::_executor($db_connection, $sqlQuery, $params, true);
        }

        private static function _executor($db_connection, $sqlQuery, $params, $is_insert) {
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
            if ($is_insert) {
                return $db_connection->lastInsertId();
            }
            $result = $sth->fetchAll();
            return $result;
        }
    }
?>