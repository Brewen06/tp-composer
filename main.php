<?php
print("Premiers pas avec la gestion des erreurs (exceptions) \n\n")
;require 'vendor/autoload.php';

use PDOException;
use Monolog\Level;
use Monolog\Logger;
//use PHPMailer\PHPMailer\PHPMailer;
use Monolog\Handler\StreamHandler;
use Symfony\Component\Dotenv\Dotenv;

function addfighter($l, $DATABASE_HOST, $DATABASE_NAME, $DATABASE_USER, $DATABASE_PASSWORD, $DATABASE_PORT, $DATABASE_DIALECT)
{
    try
    {
        $l->info("try to connect to the database $DATABASE_NAME on $DATABASE_HOST:$DATABASE_PORT");
        $dbh = new PDO("$DATABASE_DIALECT:host=$DATABASE_HOST;port=$DATABASE_PORT;dbname=$DATABASE_NAME", $DATABASE_USER, $DATABASE_PASSWORD);

        $stmt = $dbh->prepare("INSERT INTO fighters (name, strength, defense) VALUES (:name, :strength, :defense)");

        $name     = "Miss Fortune";
        $strength = 100;
        $defense  = 50;

        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':strength', $strength);
        $stmt->bindParam(':defense', $defense);
        $stmt->execute();

        $l->info("Le combattant a été ajouté dans la base de données");
    } catch (PDOException $th) {
        $l->error("Connection failed: " . $th->getMessage());
    }
}
function checkStrength($strength) {
    if($strength < 0) {
        throw new Exception('La force du guerrier ne peut pas être négative');
    }
}

// add records to the log
$log = new Logger("'Application SIO");
$log->pushHandler(new StreamHandler('log/info.log', Level::Debug));

$dotenv = new Dotenv();
$dotenv->load(__DIR__ . '/.env');

// addfighter($log, $_ENV['DATABASE_HOST'], $_ENV['DATABASE_NAME'], $_ENV['DATABASE_USER'], $_ENV['DATABASE_PASSWORD'], $_ENV['DATABASE_PORT'], $_ENV['DATABASE_DIALECT']);
try {
    // Code qui peut lever une exception
    checkStrength(-5);
} catch(\Throwable $th) {
    echo 'Erreur : ' . $th->getMessage() . "\n\n";
}
echo "Le programme continue. \n\n";