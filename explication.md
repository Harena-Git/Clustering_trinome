# Explication complète du projet de clustering

## 1. Présentation générale
Ce projet est une infrastructure de clustering utilisant plusieurs technologies : PHP, MySQL, HAProxy, Docker. Il vise à créer un environnement haute disponibilité et équilibrage de charge pour des applications web avec une base de données répliquée.

## 2. Fonctionnalités principales

### 2.1. Clustering et haute disponibilité
- Utilisation de deux serveurs web (web-server1 et web-server2) pour assurer la redondance et la répartition de charge.
- HAProxy agit comme un load balancer HTTP et MySQL pour distribuer les requêtes entre les serveurs web et bases de données.

### 2.2. Réplication MySQL master-to-master
- Deux bases de données MySQL (db1 et db2) configurées en réplication master-to-master.
- Permet la synchronisation des données entre les deux bases pour assurer la continuité de service.
- Scripts d'initialisation et configuration spécifique pour la réplication.

### 2.3. Conteneurisation avec Docker
- Chaque composant (serveurs web, bases de données, HAProxy) est isolé dans un conteneur Docker.
- Utilisation de Docker Compose pour orchestrer et gérer les conteneurs.
- Facilite le déploiement, la montée en charge et la maintenance.

## 3. Architecture du projet

- **haproxy-http** : Conteneur HAProxy pour le load balancing HTTP sur les serveurs web.
- **haproxy-db** : Conteneur HAProxy pour le load balancing MySQL entre les bases de données.
- **web-server1 et web-server2** : Conteneurs des serveurs web PHP.
- **db1 et db2** : Conteneurs MySQL configurés en master-to-master.
- **web-interface** : Interface web d'administration et monitoring.

## 4. Description métier

### 4.1. Serveurs web
- Hébergent l'application PHP qui sert les utilisateurs.
- Répartis en deux instances pour assurer la disponibilité et la répartition de charge.

### 4.2. Bases de données
- Stockent les données de l'application.
- Répliquées en master-to-master pour garantir la synchronisation et la tolérance aux pannes.

### 4.3. HAProxy
- Gère la distribution des requêtes HTTP et MySQL.
- Permet de basculer automatiquement en cas de panne d'un serveur.

### 4.4. Interface web
- Permet de visualiser l'état du cluster, les statistiques HAProxy, et d'interagir avec le système.

## 5. Interface utilisateur

- Accessible via le port 8081 (ou 8090 pour HAProxy HTTP selon configuration).
- Propose une interface graphique pour surveiller les serveurs et bases.
- Affiche les statistiques de charge, les états des serveurs, et les logs.

## 6. Déploiement
- Le projet est déployé via Docker Compose, qui construit et lance tous les conteneurs.
- Les configurations spécifiques sont montées dans les conteneurs via des volumes.
- Les scripts d'initialisation des bases de données sont exécutés au démarrage.

## 7. Conclusion
Ce projet permet de mettre en place un environnement de clustering robuste, scalable et facile à déployer grâce à Docker. Il assure la haute disponibilité des applications web et la synchronisation des bases de données, tout en offrant une interface d'administration complète.
