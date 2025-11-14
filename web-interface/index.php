<?php
function checkService($host, $port, $timeout = 1) {
    $fp = @fsockopen($host, $port, $errno, $errstr, $timeout);
    if ($fp) {
        fclose($fp);
        return '<span style="color:green">OK</span>';
    } else {
        return '<span style="color:red">STOP</span>';
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Gestion Infrastructure HAProxy</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 2em; }
        h1 { color: #2c3e50; }
        .etat { margin-bottom: 2em; }
        .ajout { margin-bottom: 2em; }
        label { margin-right: 1em; }
    </style>
</head>
<body>
    <h1>Gestion Infrastructure HAProxy</h1>
    <div class="etat">
        <h2>État des services</h2>
        <ul>
            <li>Proxy HTTP : <?php echo checkService('haproxy-http', 80); ?></li>
            <li>Proxy Base de données : <?php echo checkService('haproxy-db', 3307); ?></li>
            <li>Webserver 1 : <?php echo checkService('webserver1', 80); ?></li>
            <li>Webserver 2 : <?php echo checkService('webserver2', 80); ?></li>
            <li>DB 1 : <?php echo checkService('db1', 3306); ?></li>
            <li>DB 2 : <?php echo checkService('db2', 3306); ?></li>
        </ul>
    </div>
    <div class="ajout">
        <h2>Ajouter une base de données</h2>
        <form method="post" action="ajout_db.php">
            <label>Nom du conteneur : <input type="text" name="container" required></label>
            <label>Mot de passe root : <input type="text" name="password" required></label>
            <button type="submit">Ajouter</button>
        </form>
    </div>
    <div>
        <h2>Rafraîchir l'état</h2>
        <form method="get">
            <button type="submit">Rafraîchir</button>
        </form>
    </div>
    <div style="margin-top:2em;">
        <h2>Accès aux serveurs web</h2>
        <ul>
            <li><a href="http://localhost:8090/">Web Server 1 ou 2 (via HAProxy HTTP)</a></li>
            <li><a href="http://localhost:8082/">Web Server 1 (accès direct)</a></li>
            <li><a href="http://localhost:8083/">Web Server 2 (accès direct)</a></li>
        </ul>
    </div>
</body>
</html>
