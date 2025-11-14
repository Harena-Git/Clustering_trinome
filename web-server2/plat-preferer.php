<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['plat'])) {
    $_SESSION['plat_preferer'] = trim($_POST['plat']);
}

$plat = isset($_SESSION['plat_preferer']) ? $_SESSION['plat_preferer'] : '';

?><!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Plat préféré (Session MySQL)</title>
</head>
<body>
    <h1>Test de synchronisation du plat préféré</h1>
    <form method="post">
        <label for="plat">Votre plat préféré :</label>
        <input type="text" id="plat" name="plat" value="<?php echo htmlspecialchars($plat); ?>">
        <button type="submit">Enregistrer</button>
    </form>
    <hr>
    <h2>Plat préféré enregistré en session :</h2>
    <div style="font-size:1.5em;color:blue;">
        <?php echo $plat ? htmlspecialchars($plat) : '<em>Aucun plat enregistré</em>'; ?>
    </div>
    <hr>
    <div style="font-size:0.9em;color:gray;">
        Session ID : <?php echo session_id(); ?>
    </div>
</body>
</html>
