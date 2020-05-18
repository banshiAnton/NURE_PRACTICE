<?php
    class DBCredentials {
        const DRIVER = "mysql";
        const HOST = "localhost";  
        const DB_NAME = "nure_practice";
        const USER_NAME = "root";
        const PASSWORD = "";
        const DNS = self::DRIVER.':host='.self::HOST.'; dbname='.self::DB_NAME;
    }
?>