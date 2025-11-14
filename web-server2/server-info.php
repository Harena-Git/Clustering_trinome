<?php
// server-info.php - Affiche les informations du serveur
$server_ip = $_SERVER['SERVER_ADDR'] ?? 'Non disponible';
$hostname = gethostname();
$client_ip = $_SERVER['REMOTE_ADDR'] ?? 'Non disponible';
$server_port = $_SERVER['SERVER_PORT'] ?? 'Non disponible';
$request_time = $_SERVER['REQUEST_TIME'] ?? time();
$current_time = date('Y-m-d H:i:s');

// Démarrer la session pour le compteur de visites
session_start();
if (!isset($_SESSION['visit_count'])) {
    $_SESSION['visit_count'] = 1;
} else {
    $_SESSION['visit_count']++;
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Informations du Serveur</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 2em; }
        .info-box { 
            background-color: #f8f9fa; 
            border: 1px solid #dee2e6; 
            border-radius: 5px; 
            padding: 15px; 
            margin: 10px 0; 
        }
        .server1 { border-left: 5px solid #007bff; }
        .server2 { border-left: 5px solid #28a745; }
        .label { font-weight: bold; color: #495057; }
        .session-id { 
            background-color: #e9ecef; 
            padding: 5px; 
            border-radius: 3px; 
            font-family: monospace; 
            word-break: break-all;
        }
    </style>
</head>
<body>
    <h1>Informations du Serveur</h1>
    
    <div class="info-box <?php echo $hostname === 'webserver1' ? 'server1' : 'server2'; ?>">
        <h2>Serveur qui traite la requête :</h2>
        <p><span class="label">Nom d'hôte :</span> <?php echo htmlspecialchars($hostname); ?></p>
        <p><span class="label">Adresse IP du serveur :</span> <?php echo htmlspecialchars($server_ip); ?></p>
        <p><span class="label">Port du serveur :</span> <?php echo htmlspecialchars($server_port); ?></p>
        <p><span class="label">Heure du serveur :</span> <?php echo $current_time; ?></p>
    </div>
    
    <div class="info-box">
        <h2>Informations client :</h2>
        <p><span class="label">Adresse IP du client :</span> <?php echo htmlspecialchars($client_ip); ?></p>
        <p><span class="label">Heure de la requête :</span> <?php echo date('Y-m-d H:i:s', $request_time); ?></p>
        <p><span class="label">User Agent :</span> <?php echo htmlspecialchars($_SERVER['HTTP_USER_AGENT'] ?? 'Non disponible'); ?></p>
    </div>
    
    <div class="info-box">
        <h2>Informations de session :</h2>
        <p><span class="label">ID de session :</span> <span class="session-id"><?php echo session_id(); ?></span></p>
        <p><span class="label">Nombre de visites :</span> <?php echo $_SESSION['visit_count']; ?></p>
        <p><span class="label">Dernier accès :</span> <?php echo isset($_SESSION['last_access']) ? date('Y-m-d H:i:s', $_SESSION['last_access']) : 'Première visite'; ?></p>
        <?php $_SESSION['last_access'] = time(); ?>
    </div>
    
    <div class="info-box">
        <h2>Test de répartition de charge :</h2>
        <p>Rafraîchissez cette page plusieurs fois pour voir si HAProxy alterne entre les serveurs.</p>
        <form method="post">
            <button type="submit" name="refresh">Rafraîchir la page</button>
        </form>
    </div>
    
    <div style="margin-top: 20px;">
        <a href="index.php">Retour à l'accueil</a> | 
        <a href="plat-preferer.php">Test session MySQL</a>
    </div>
</body>
</html>