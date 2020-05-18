<?php
    require_once __DIR__.'/../config/db-config.php';
    $options = array(PDO::ATTR_PERSISTENT => true, PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8');
    try {
        $db_connection = new PDO (DBCredentials::DNS, DBCredentials::USER_NAME, DBCredentials::PASSWORD, $options);
        $db_connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $db_connection;
    } catch (PDOException $e) {
        echo "Error!: " . $e->getMessage() . "<br/>"; die();
    }
?>