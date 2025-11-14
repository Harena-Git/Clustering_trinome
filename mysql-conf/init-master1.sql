-- Script d'initialisation pour db1 (master1)
CREATE USER IF NOT EXISTS 'repl'@'%' IDENTIFIED BY 'replpass';
GRANT REPLICATION SLAVE ON *.* TO 'repl'@'%';
FLUSH PRIVILEGES;
-- Pour la réplication, à exécuter manuellement :
-- CHANGE MASTER TO MASTER_HOST='db2', MASTER_USER='repl', MASTER_PASSWORD='replpass', MASTER_AUTO_POSITION=1;
