<?php
// test-replication.php : Interface web pour tester la réplication master-to-master
function testReplication($host1, $host2, $user, $pass) {
    $db = 'replicadb';
    $table = 'test_table';
    $mysqli1 = new mysqli($host1, $user, $pass);
    $mysqli2 = new mysqli($host2, $user, $pass);
    if ($mysqli1->connect_errno || $mysqli2->connect_errno) {
        return 'Erreur de connexion à MySQL.';
    }
    // Création base/table sur db1
    $mysqli1->query("CREATE DATABASE IF NOT EXISTS $db");
    $mysqli1->select_db($db);
    $mysqli1->query("CREATE TABLE IF NOT EXISTS $table (id INT PRIMARY KEY AUTO_INCREMENT, val VARCHAR(50))");
    $mysqli1->query("INSERT INTO $table (val) VALUES ('test-replication')");
    sleep(2); // Laisser le temps à la réplication
    // Vérifier sur db2
    $mysqli2->select_db($db);
    $res = $mysqli2->query("SELECT * FROM $table WHERE val='test-replication'");
    if ($res && $res->num_rows > 0) {
        return 'Succès : La ligne a été répliquée sur le second serveur.';
    } else {
        return 'Échec : La ligne n\'a pas été trouvée sur le second serveur.';
    }
}
$msg = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $msg = testReplication('db1', 'db2', 'root', 'example');
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Test Master-to-Master</title>
</head>
<body>
    <h1>Test Master-to-Master MySQL</h1>
    <form method="post">
        <button type="submit">Lancer le test de réplication</button>
    </form>
    <?php if ($msg): ?>
        <p><strong>Résultat :</strong> <?= htmlspecialchars($msg) ?></p>
    <?php endif; ?>
    <a href="index.php">Retour</a>
</body>
</html>
