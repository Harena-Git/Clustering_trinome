<?php
// ajout_db.php - Ajoute une base de données sur db1 et db2 et configure la réplication
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $dbname = preg_replace('/[^a-zA-Z0-9_]/', '', $_POST['container']);
    if (!$dbname) {
        header('Location: index.php');
        exit;
    }
    $user = 'root';
    $pass = 'example';
    $host1 = 'db1';
    $host2 = 'db2';
    // Création de la base sur db1 et db2
    $mysqli1 = @new mysqli($host1, $user, $pass);
    $mysqli2 = @new mysqli($host2, $user, $pass);
    if ($mysqli1->connect_errno || $mysqli2->connect_errno) {
        header('Location: index.php');
        exit;
    }
    $mysqli1->query("CREATE DATABASE IF NOT EXISTS `$dbname`");
    $mysqli2->query("CREATE DATABASE IF NOT EXISTS `$dbname`");
    // Création d'une table de test
    $mysqli1->select_db($dbname);
    $mysqli2->select_db($dbname);
    $mysqli1->query("CREATE TABLE IF NOT EXISTS test_replication (id INT PRIMARY KEY AUTO_INCREMENT, val VARCHAR(50))");
    $mysqli2->query("CREATE TABLE IF NOT EXISTS test_replication (id INT PRIMARY KEY AUTO_INCREMENT, val VARCHAR(50))");
    $mysqli1->close();
    $mysqli2->close();
    header('Location: index.php');
    exit;
}
?>