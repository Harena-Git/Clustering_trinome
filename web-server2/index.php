<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Accueil - Web Server 2</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            min-height: 100vh;
            padding: 20px;
            color: #333;
        }
        
        .container {
            max-width: 1200px;
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
            font-size: 1.2em;
        }
        
        .server-info {
            background: linear-gradient(135deg, #4facfe, #00f2fe);
            color: white;
            padding: 20px;
            border-radius: 12px;
            margin-bottom: 30px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
        }
        
        .server-info h3 {
            margin-bottom: 10px;
            font-size: 1.3em;
        }
        
        .server-info .details {
            font-family: 'Courier New', monospace;
            background: rgba(255,255,255,0.2);
            padding: 10px;
            border-radius: 6px;
            font-size: 1.1em;
        }
        
        .nav-cards {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }
        
        .card {
            background: white;
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            text-decoration: none;
            color: inherit;
            display: block;
        }
        
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 30px rgba(0,0,0,0.15);
        }
        
        .card h3 {
            color: #4a5568;
            margin-bottom: 10px;
            font-size: 1.4em;
        }
        
        .card p {
            color: #718096;
            line-height: 1.6;
        }
        
        .card.session {
            border-left: 4px solid #48bb78;
        }
        
        .card.test {
            border-left: 4px solid #ed8936;
        }
        
        .card.info {
            border-left: 4px solid #4299e1;
        }
        
        .footer {
            text-align: center;
            color: white;
            margin-top: 40px;
            opacity: 0.8;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🚀 Bienvenue sur Web Server 2</h1>
            <p>Ce serveur gère les sessions via MySQL répliqué</p>
        </div>
        
        <div class="server-info">
            <h3>📍 Serveur actuel</h3>
            <div class="details">
                <?php 
                    echo $_SERVER['SERVER_ADDR'] . ' (' . gethostname() . ')';
                ?>
            </div>
        </div>
        
        <div class="nav-cards">
            <a href="plat-preferer.php" class="card session">
                <h3>🍽️ Test Plat Préféré</h3>
                <p>Tester la synchronisation des sessions MySQL entre les serveurs</p>
            </a>
            
            <a href="sessionHandler.php" class="card test">
                <h3>🔧 Handler de Session</h3>
                <p>Tester le gestionnaire personnalisé de sessions PHP/MySQL</p>
            </a>
            
            <a href="test-session.php" class="card test">
                <h3>🧪 Test Session Simple</h3>
                <p>Tester le fonctionnement basique des sessions</p>
            </a>
            
            <a href="server-info.php" class="card info">
                <h3>📊 Informations Serveur</h3>
                <p>Voir les détails techniques du serveur et tester la répartition de charge</p>
            </a>
        </div>
        
        <div class="footer">
            <p>Infrastructure HAProxy • MySQL Master-to-Master • Load Balancing</p>
        </div>
    </div>
</body>
</html>