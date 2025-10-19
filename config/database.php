<?php
/**
 * -------------------------------------------------------------
 * DATABASE CONFIGURATIE - JaminMagazijn
 * -------------------------------------------------------------
 * Gebruikt PDO (PHP Data Objects) voor veilige databaseverbinding.
 * Deze file wordt geïmporteerd in je BaseModel of Database-class.
 * -------------------------------------------------------------
 */

return [
    'driver'   => 'mysql',
    'host'     => 'localhost',
    'port'     => '3306',
    'database' => 'JaminMagazijn',
    'username' => 'root',         // pas aan als je een andere gebruiker hebt
    'password' => '',             // vul in als je root-wachtwoord hebt
    'charset'  => 'utf8mb4',
    'collation'=> 'utf8mb4_unicode_ci',
    'options'  => [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,  // gooit exceptions bij fouten
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,        // standaard: assoc array
        PDO::ATTR_EMULATE_PREPARES   => false,                   // gebruik echte prepared statements
    ],
];
