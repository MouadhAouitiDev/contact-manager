<?php

// Chemin vers le fichier de log
$log_file = __DIR__ . '/logs/app.log';

// Fonction pour écrire dans le fichier de log
function write_log($message) {
    global $log_file;
    
    // Assurez-vous que le fichier de log est accessible
    if (!is_writable($log_file)) {
        echo "Erreur : Le fichier de log n'est pas accessible.";
        return;
    }

    // Créer un message avec horodatage
    $timestamp = date("Y-m-d H:i:s");
    $log_message = "[$timestamp] $message" . PHP_EOL;

    // Ajouter le message au fichier log
    file_put_contents($log_file, $log_message, FILE_APPEND);
}

$host = 'db';
$dbname = 'db';
$username = 'db';
$password = 'db';

try {
    // Tentative de connexion à la base de données
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Log de succès de connexion
    write_log("Connexion à la base de données réussie.");
} catch (PDOException $e) {
    // Log d'erreur de connexion
    write_log("Erreur de connexion à la base de données : " . $e->getMessage());
    // Affichage du message d'erreur
    die("Erreur de connexion à la base de données : " . $e->getMessage());
}
?>
