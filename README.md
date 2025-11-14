# Intégration des serveurs web et gestion des sessions

## Architecture

- `webserver1` et `webserver2` sont deux conteneurs PHP/Apache distincts, chacun embarquant le code de `server1` et `server2`.
- HAProxy répartit les requêtes HTTP entre ces deux serveurs.
- Les sessions utilisateurs sont stockées dans une base MySQL (`sessionsdb`) via HAProxy (host `haproxy-db`, port 3307).
- Grâce à la réplication master-to-master, les sessions sont visibles et accessibles depuis les deux serveurs web, quel que soit celui qui répond à la requête.

## Fonctionnement de la gestion de session

1. Lorsqu'un utilisateur se connecte, la session PHP est enregistrée dans la table `php_sessions` de la base `sessionsdb`.
2. Si l'utilisateur est redirigé vers l'autre serveur web, la session reste accessible car la base est répliquée.
3. Le handler PHP personnalisé utilise PDO pour écrire/lire les sessions dans MySQL.

## Déploiement

1. Les dossiers `web-server1` et `web-server2` contiennent chacun un Dockerfile et le code PHP.
2. Le `docker-compose.yml` build et lance les deux serveurs web, les MySQL, et HAProxy.
3. Le script `init-sessions.sql` initialise la base et la table des sessions sur les deux MySQL.

## Exemple de flux

1. L'utilisateur arrive sur HAProxy (port 8090).
2. HAProxy envoie la requête à `webserver1` ou `webserver2`.
3. Le code PHP gère la session et l'enregistre dans MySQL via HAProxy.
4. Si la requête suivante arrive sur l'autre serveur, la session est retrouvée grâce à la réplication.
# Guide étape par étape : Infrastructure HAProxy, Docker, MySQL master-to-master et interface web

## 1. Prérequis
- Docker et Docker Compose installés sur votre machine

## 2. Structure du projet
- `haproxy-http/` : Configuration HAProxy pour la répartition HTTP
- `haproxy-db/` : Configuration HAProxy pour la répartition base de données
- `web-interface/` : Interface web de gestion (PHP)
- `mysql-conf/` : Fichiers de configuration et scripts d'init MySQL
- `docker-compose.yml` : Orchestration de tous les services

## 3. Démarrage de l'infrastructure
1. Ouvrez un terminal dans le dossier `infra_haproxy_docker`
2. Lancez tous les services :
   ```powershell
   docker-compose up -d
   ```

icacls .\mysql-conf\my-master1.cnf /inheritance:r
icacls .\mysql-conf\my-master1.cnf /grant:r "${env:USERNAME}:R"
icacls .\mysql-conf\my-master2.cnf /inheritance:r
icacls .\mysql-conf\my-master2.cnf /grant:r "${env:USERNAME}:R"

## 4. Initialisation de la réplication master-to-master (à faire une seule fois après le tout premier démarrage)
1. Dans le terminal, exécutez :
   ```powershell
   docker exec db1 bash /init-replication.sh
   docker exec db2 bash /init-replication.sh
   ```
2. La réplication est maintenant active entre db1 et db2 pour toutes les bases créées.

## 5. Utilisation de l'interface web
1. Ouvrez votre navigateur sur : http://localhost:8081
2. Pour ajouter une base de données :
   - Remplissez le formulaire "Ajouter une base de données"
   - La base sera créée sur db1 et db2, avec une table de test, et sera automatiquement répliquée
3. Pour tester la réplication :
   - Utilisez la page de test (ex : `test-replication.php`) pour insérer une donnée et vérifier sa présence sur l'autre serveur

  cd infra_haproxy_docker; docker-compose build web-interface
  cd infra_haproxy_docker; docker-compose up -d

cd infra_haproxy_docker; docker-compose build webserver1 webserver2
cd infra_haproxy_docker; docker-compose up -d

## 6. Gestion et supervision
- Pour voir l'état des services : consultez la section "État des services" sur l'interface web
- Pour voir les logs d'un service :
  ```powershell
  docker-compose logs <nom_du_service>
  ```
- Pour arrêter tous les services :
  ```powershell
  docker-compose down
  ```
- Pour redémarrer un service :
  ```powershell
  docker-compose restart <nom_du_service>
  ```

## 7. Schéma d'architecture
```
Client
  |
Proxy (HAProxy HTTP)
 /   \
Web1 Web2
  \   /
Proxy (HAProxy DB)
 /   \
DB1  DB2 (master-master)
```

---

**Remarques :**
- Les configurations HAProxy sont simples et adaptables
- L'ajout de base via l'interface web crée la base sur les deux serveurs et la réplication s'applique automatiquement
- Pour la production, pensez à sécuriser l'interface et à améliorer la supervision
