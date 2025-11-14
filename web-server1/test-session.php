<?php
require_once 'sessionHandler.php';
// L'initialisation du handler et session_start sont déjà faits dans sessionHandler.php
$_SESSION['test'] = $_SESSION['test'] ?? uniqid();
echo "Session ID: " . session_id() . "<br>";
echo "Valeur test: " . $_SESSION['test'];
