<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['plat'])) {
    $_SESSION['plat_preferer'] = trim($_POST['plat']);
}

$plat = isset($_SESSION['plat_preferer']) ? $_SESSION['plat_preferer'] : '';

// Déterminer le thème couleur basé sur le serveur
$hostname = gethostname();
$is_server1 = $hostname === 'webserver1';
$theme_gradient = $is_server1 ? 'linear-gradient(135deg, #667eea 0%, #764ba2 100%)' : 'linear-gradient(135deg, #f093fb 0%, #f5576c 100%)';
$primary_color = $is_server1 ? '#667eea' : '#f5576c';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Plat préféré (Session MySQL)</title>
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
            max-width: 800px;
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
            font-size: 2.2em;
            margin-bottom: 10px;
        }
        
        .server-info {
            background: linear-gradient(135deg, <?php echo $is_server1 ? '#4facfe, #00f2fe' : '#ff6b6b, #ee5a24'; ?>);
            color: white;
            padding: 20px;
            border-radius: 12px;
            margin-bottom: 30px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
        }
        
        .server-info h3 {
            margin-bottom: 10px;
            font-size: 1.2em;
        }
        
        .server-info .details {
            font-family: 'Courier New', monospace;
            background: rgba(255,255,255,0.2);
            padding: 10px;
            border-radius: 6px;
            font-size: 1.1em;
        }
        
        .form-card {
            background: white;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            margin-bottom: 30px;
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #4a5568;
            font-size: 1.1em;
        }
        
        input[type="text"] {
            width: 100%;
            padding: 12px 15px;
            border: 2px solid #e2e8f0;
            border-radius: 8px;
            font-size: 1em;
            transition: border-color 0.3s ease;
        }
        
        input[type="text"]:focus {
            outline: none;
            border-color: <?php echo $primary_color; ?>;
        }
        
        .btn {
            background: <?php echo $primary_color; ?>;
            color: white;
            padding: 12px 30px;
            border: none;
            border-radius: 8px;
            font-size: 1.1em;
            cursor: pointer;
            transition: background 0.3s ease;
        }
        
        .btn:hover {
            background: <?php echo $is_server1 ? '#5a6fd8' : '#e53e3e'; ?>;
            transform: translateY(-2px);
        }
        
        .result-card {
            background: white;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            margin-bottom: 30px;
            text-align: center;
        }
        
        .result-card h2 {
            color: #4a5568;
            margin-bottom: 20px;
            font-size: 1.5em;
        }
        
        .plat-value {
            font-size: 2em;
            color: <?php echo $primary_color; ?>;
            font-weight: bold;
            margin: 20px 0;
            padding: 20px;
            background: #f8fafc;
            border-radius: 10px;
            border-left: 4px solid <?php echo $primary_color; ?>;
        }
        
        .session-info {
            background: #f8fafc;
            padding: 20px;
            border-radius: 10px;
            margin-top: 20px;
            border-left: 4px solid #a0aec0;
        }
        
        .session-id {
            font-family: 'Courier New', monospace;
            background: white;
            padding: 10px;
            border-radius: 6px;
            word-break: break-all;
            margin-top: 10px;
        }
        
        .nav-links {
            text-align: center;
            margin-top: 30px;
        }
        
        .nav-links a {
            color: white;
            text-decoration: none;
            margin: 0 10px;
            padding: 10px 20px;
            background: rgba(255,255,255,0.2);
            border-radius: 8px;
            transition: background 0.3s ease;
        }
        
        .nav-links a:hover {
            background: rgba(255,255,255,0.3);
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🍽️ Test de synchronisation du plat préféré</h1>
            <p>Sessions MySQL répliquées entre serveurs</p>
        </div>
        
        <div class="server-info">
            <h3>📍 Serveur actuel</h3>
            <div class="details">
                <?php 
                    echo $_SERVER['SERVER_ADDR'] . ' (' . gethostname() . ')';
                ?>
            </div>
        </div>
        
        <div class="form-card">
            <form method="post">
                <div class="form-group">
                    <label for="plat">Votre plat préféré :</label>
                    <input type="text" id="plat" name="plat" value="<?php echo htmlspecialchars($plat); ?>" 
                           placeholder="Entrez votre plat préféré...">
                </div>
                <button type="submit" class="btn">💾 Enregistrer dans la session</button>
            </form>
        </div>
        
        <div class="result-card">
            <h2>🍽️ Plat préféré enregistré en session :</h2>
            <div class="plat-value">
                <?php echo $plat ? htmlspecialchars($plat) : '<em style="color:#a0aec0;">Aucun plat enregistré</em>'; ?>
            </div>
            
            <div class="session-info">
                <strong>Session ID :</strong>
                <div class="session-id"><?php echo session_id(); ?></div>
            </div>
        </div>
        
        <div class="nav-links">
            <a href="index.php">🏠 Accueil</a>
            <a href="server-info.php">📊 Infos Serveur</a>
            <a href="sessionHandler.php">🔧 Handler Session</a>
        </div>
    </div>
</body>
</html>