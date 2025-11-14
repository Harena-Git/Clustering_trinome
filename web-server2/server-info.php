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

// Déterminer le thème couleur basé sur le serveur
$is_server1 = $hostname === 'webserver1';
$theme_gradient = $is_server1 ? 'linear-gradient(135deg, #667eea 0%, #764ba2 100%)' : 'linear-gradient(135deg, #f093fb 0%, #f5576c 100%)';
$server_color = $is_server1 ? '#667eea' : '#f5576c';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Informations du Serveur</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: <?php echo $theme_gradient; ?>;
            min-height: 100vh;
            padding: 20px;
            color: #333;
        }
        
        .container {
            max-width: 1000px;
            margin: 0 auto;
        }
        
        .header {
            background: white;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            margin-bottom: 30px;
            text-align: center;
        }
        
        .header h1 {
            color: #4a5568;
            font-size: 2.5em;
            margin-bottom: 10px;
        }
        
        .header p {
            color: #718096;
            font-size: 1.1em;
        }
        
        .info-grid {
            display: grid;
            gap: 25px;
            margin-bottom: 30px;
        }
        
        .info-card {
            background: white;
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            border-left: 4px solid <?php echo $server_color; ?>;
        }
        
        .info-card h2 {
            color: #4a5568;
            margin-bottom: 20px;
            font-size: 1.5em;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .info-item {
            margin-bottom: 15px;
            padding: 12px;
            background: #f8fafc;
            border-radius: 8px;
            border-left: 3px solid <?php echo $server_color; ?>;
        }
        
        .label {
            font-weight: 600;
            color: #4a5568;
            display: block;
            margin-bottom: 5px;
        }
        
        .value {
            color: #718096;
            font-family: 'Courier New', monospace;
            background: white;
            padding: 8px 12px;
            border-radius: 6px;
            border: 1px solid #e2e8f0;
            display: block;
            word-break: break-all;
        }
        
        .session-id {
            background: #edf2f7;
            padding: 10px;
            border-radius: 6px;
            font-family: 'Courier New', monospace;
            word-break: break-all;
            border: 1px solid #e2e8f0;
        }
        
        .btn {
            background: <?php echo $server_color; ?>;
            color: white;
            padding: 12px 24px;
            border: none;
            border-radius: 8px;
            font-size: 1em;
            cursor: pointer;
            transition: background 0.3s ease;
            text-decoration: none;
            display: inline-block;
        }
        
        .btn:hover {
            background: <?php echo $is_server1 ? '#5a6fd8' : '#e53e3e'; ?>;
        }
        
        .nav-links {
            text-align: center;
            margin-top: 30px;
        }
        
        .nav-links a {
            color: white;
            text-decoration: none;
            margin: 0 15px;
            padding: 10px 20px;
            background: rgba(255,255,255,0.2);
            border-radius: 8px;
            transition: background 0.3s ease;
        }
        
        .nav-links a:hover {
            background: rgba(255,255,255,0.3);
        }
        
        .server-badge {
            background: <?php echo $server_color; ?>;
            color: white;
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 0.8em;
            font-weight: 600;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>📊 Informations du Serveur</h1>
            <p>Détails techniques et monitoring de l'infrastructure</p>
        </div>
        
        <div class="info-grid">
            <div class="info-card">
                <h2>🖥️ Serveur de traitement</h2>
                <div class="info-item">
                    <span class="label">Nom d'hôte</span>
                    <span class="value"><?php echo htmlspecialchars($hostname); ?></span>
                </div>
                <div class="info-item">
                    <span class="label">Adresse IP du serveur</span>
                    <span class="value"><?php echo htmlspecialchars($server_ip); ?></span>
                </div>
                <div class="info-item">
                    <span class="label">Port du serveur</span>
                    <span class="value"><?php echo htmlspecialchars($server_port); ?></span>
                </div>
                <div class="info-item">
                    <span class="label">Heure du serveur</span>
                    <span class="value"><?php echo $current_time; ?></span>
                </div>
            </div>
            
            <div class="info-card">
                <h2>👤 Informations client</h2>
                <div class="info-item">
                    <span class="label">Adresse IP du client</span>
                    <span class="value"><?php echo htmlspecialchars($client_ip); ?></span>
                </div>
                <div class="info-item">
                    <span class="label">Heure de la requête</span>
                    <span class="value"><?php echo date('Y-m-d H:i:s', $request_time); ?></span>
                </div>
                <div class="info-item">
                    <span class="label">User Agent</span>
                    <span class="value"><?php echo htmlspecialchars($_SERVER['HTTP_USER_AGENT'] ?? 'Non disponible'); ?></span>
                </div>
            </div>
            
            <div class="info-card">
                <h2>💾 Informations de session</h2>
                <div class="info-item">
                    <span class="label">ID de session</span>
                    <div class="session-id"><?php echo session_id(); ?></div>
                </div>
                <div class="info-item">
                    <span class="label">Nombre de visites</span>
                    <span class="value"><?php echo $_SESSION['visit_count']; ?></span>
                </div>
                <div class="info-item">
                    <span class="label">Dernier accès</span>
                    <span class="value"><?php echo isset($_SESSION['last_access']) ? date('Y-m-d H:i:s', $_SESSION['last_access']) : 'Première visite'; ?></span>
                </div>
                <?php $_SESSION['last_access'] = time(); ?>
            </div>
            
            <div class="info-card">
                <h2>⚡ Test de répartition de charge</h2>
                <p style="margin-bottom: 20px; color: #718096;">Rafraîchissez cette page plusieurs fois pour voir si HAProxy alterne entre les serveurs.</p>
                <form method="post">
                    <button type="submit" name="refresh" class="btn">🔄 Rafraîchir la page</button>
                </form>
            </div>
        </div>
        
        <div class="nav-links">
            <a href="index.php">🏠 Accueil</a>
            <a href="plat-preferer.php">🍽️ Test Session</a>
            <a href="sessionHandler.php">🔧 Handler Session</a>
        </div>
    </div>
</body>
</html>