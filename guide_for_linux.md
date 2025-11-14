# Guide d'installation et d'utilisation

## Prérequis
- Avoir suivi les étapes de configuration dans `config.md`
- Avoir Docker et Docker Compose d'installés
- Avoir cloné ce dépôt sur votre machine Ubuntu

## 1. Configuration initiale

### 1.1. Cloner le dépôt (si ce n'est pas déjà fait)
```bash
git clone [URL_DU_DEPOT]
cd infra_haproxy_docker-main
```

### 1.2. Configurer les variables d'environnement
Créez un fichier `.env` à la racine du projet avec le contenu suivant :
```
MYSQL_ROOT_PASSWORD=votre_mot_de_passe
MYSQL_DATABASE=cluster_db
MYSQL_USER=cluster_user
MYSQL_PASSWORD=cluster_password
```

## 2. Construction et démarrage des conteneurs

### 2.1. Construire les images personnalisées
```bash
docker-compose build
```

### 2.2. Démarrer tous les services
```bash
docker-compose up -d
```

### 2.3. Vérifier l'état des conteneurs
```bash
docker-compose ps
```
Tous les services devraient être en état "Up".

## 3. Accès aux services

### 3.1. Interface Web
- **HAProxy Stats**: http://votre_serveur:8090
- **Interface d'administration**: http://votre_serveur:8081
- **Serveur Web 1**: http://votre_serveur:8082
- **Serveur Web 2**: http://votre_serveur:8083

### 3.2. Accès aux bases de données
- **HAProxy MySQL**: `mysql -h localhost -P 3307 -u root -p`
- **Base de données 1 directe**: `mysql -h localhost -P 3306 -u root -p`
- **Base de données 2 directe**: `mysql -h localhost -P 3307 -u root -p`

## 4. Gestion du cluster

### 4.1. Arrêter les conteneurs
```bash
docker-compose down
```

### 4.2. Redémarrer les conteneurs
```bash
docker-compose restart
```

### 4.3. Voir les logs
```bash
# Tous les logs
docker-compose logs -f

# Logs d'un service spécifique (ex: haproxy-http)
docker-compose logs -f haproxy-http
```

## 5. Surveillance et maintenance

### 5.1. Vérifier l'état de la réplication MySQL
```bash
docker exec -it db1 mysql -uroot -p -e "SHOW SLAVE STATUS\G"
docker exec -it db2 mysql -uroot -p -e "SHOW SLAVE STATUS\G"
```

### 5.2. Vérifier l'état des serveurs dans HAProxy
```bash
echo "show stat" | socat unix-connect:/var/run/haproxy.sock stdio
```

## 6. Dépannage

### 6.1. Si un conteneur ne démarre pas
```bash
docker logs [NOM_DU_CONTENEUR]
docker-compose logs [NOM_DU_SERVICE]
```

### 6.2. Nettoyer les conteneurs arrêtés
```bash
docker container prune
docker volume prune
```

## 7. Sauvegarde et restauration

### 7.1. Sauvegarder les bases de données
```bash
# Pour db1
docker exec db1 /usr/bin/mysqldump -u root --password=example --all-databases > backup_db1_$(date +%Y%m%d).sql

# Pour db2
docker exec db2 /usr/bin/mysqldump -u root --password=example --all-databases > backup_db2_$(date +%Y%m%d).sql
```

### 7.2. Restaurer une base de données
```bash
cat backup_file.sql | docker exec -i db1 /usr/bin/mysql -u root --password=example
```

## 8. Mise à jour du projet

### 8.1. Mettre à jour le code source
```bash
git pull origin main
```

### 8.2. Reconstruire et redémarrer les conteneurs
```bash
docker-compose down
docker-compose up -d --build
```

## Conclusion
Votre environnement de clustering est maintenant opérationnel. Vous pouvez accéder aux différentes interfaces web et gérer votre infrastructure via les commandes Docker et Docker Compose fournies dans ce guide.
