<?php
define('DB_HOST', 'localhost');
define('DB_NAME', 'np03cs4a240022');
define('DB_USER', 'np03cs4a240022');
define('DB_PASS', 'tybo8lFDsh');


$dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=" . DB_CHARSET;    //Creating  DSN (Data Source Name)


$options = [PDO::ATTR_ERRMODE=> PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,];


try {

    $pdo = new PDO($dsn, DB_USER, DB_PASS, $options);
} 
catch (PDOException $e) {

    error_log("Database Connection Error: " . $e->getMessage());

    die("Database connection failed. Please contact the administrator.");
}

function getDB() {  //function to get database connection

    global $pdo;
    return $pdo;
}
?>
