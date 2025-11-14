#!/bin/bash
# Script d'initialisation automatique de la réplication master-to-master
# À monter dans les deux conteneurs et à exécuter après le démarrage

MYSQL_ROOT_PASSWORD=
REPL_USER=repl
REPL_PASS=replpass

# Attendre que MySQL soit prêt
until mysqladmin ping -h "localhost" --silent; do
    sleep 2
done

# Détecter le nom du conteneur

if [ "$NODE_ROLE" = "db1" ]; then
    MASTER_HOST="db2"
elif [ "$NODE_ROLE" = "db2" ]; then
    MASTER_HOST="db1"
else
    echo "Ce script doit être exécuté dans db1 ou db2."
    exit 1
fi

mysql -u root -p$MYSQL_ROOT_PASSWORD -e "STOP SLAVE; CHANGE MASTER TO MASTER_HOST='$MASTER_HOST', MASTER_USER='$REPL_USER', MASTER_PASSWORD='$REPL_PASS', MASTER_AUTO_POSITION=1; START SLAVE;"
