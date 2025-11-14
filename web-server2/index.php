<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Accueil - Web Server 2</title>
</head>
<body>
    <h1>Bienvenue sur Web Server 2</h1>
    <p>Ce serveur gère les sessions via MySQL répliqué.</p>
    
    <!-- Afficher l'IP du serveur -->
    <div style="background-color: #f0f0f0; padding: 10px; margin: 10px 0; border-radius: 5px;">
        <strong>Serveur actuel :</strong> 
        <?php 
            echo $_SERVER['SERVER_ADDR'] . ' (' . gethostname() . ')';
        ?>
    </div>
    
    <ul>
        <li><a href="plat-preferer.php">Test plat préféré (session MySQL)</a></li>
    </ul>
    <a href="sessionHandler.php">Tester la gestion de session (custom handler)</a><br>
    <a href="test-session.php">Tester la gestion de session (test simple)</a>
    <a href="server-info.php">Informations du serveur</a>
</body>
</html>