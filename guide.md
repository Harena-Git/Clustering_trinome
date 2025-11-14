# Guide d'installation et de déploiement sur Windows avec Docker

## Prérequis
- Docker Desktop installé et en fonctionnement
- PowerShell ou CMD avec droits utilisateur (exécuter en administrateur si nécessaire)
- Projet cloné ou copié localement

## 1. Préparation du projet

### 1.1. Ouvrir PowerShell ou CMD

### 1.2. Se placer dans le répertoire du projet
```powershell
cd chemin\vers\infra_haproxy_docker-main
```

## 2. Construction des images Docker

```powershell
docker-compose build
```

## 3. Démarrage des conteneurs

```powershell
docker-compose up -d
```

## 4. Vérification des conteneurs

```powershell
docker-compose ps
```
Tous les conteneurs doivent être en état "Up".

## 5. Accès aux services

- HAProxy HTTP : http://localhost:8090
- Interface Web : http://localhost:8081
- Serveur Web 1 : http://localhost:8082
- Serveur Web 2 : http://localhost:8083

## 6. Gestion des conteneurs

### 6.1. Arrêter les conteneurs
```powershell
docker-compose down
```

### 6.2. Redémarrer les conteneurs
```powershell
docker-compose restart
```

### 6.3. Voir les logs
```powershell
# Logs de tous les services
docker-compose logs -f

# Logs d'un service spécifique (ex: haproxy-http)
docker-compose logs -f haproxy-http
```

## 7. Sauvegarde et restauration des bases de données

### 7.1. Sauvegarder les bases
```powershell
# Pour db1
docker exec db1 /usr/bin/mysqldump -u root --password=example --all-databases > backup_db1.sql

# Pour db2
docker exec db2 /usr/bin/mysqldump -u root --password=example --all-databases > backup_db2.sql
```

### 7.2. Restaurer une base
```powershell
cat backup_file.sql | docker exec -i db1 /usr/bin/mysql -u root --password=example
```

## 8. Mise à jour du projet

```powershell
git pull origin main
docker-compose down
docker-compose up -d --build
```

## Notes
- Toujours vérifier que Docker Desktop est lancé avant d'exécuter les commandes.
- En cas de problème de ports, vérifier les règles du pare-feu Windows.

Votre projet est maintenant prêt à être utilisé sur Windows avec Docker.
