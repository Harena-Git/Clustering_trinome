# Configuration requise pour Windows avec Docker

## Prérequis système
- Windows 10 ou supérieur (64 bits)
- Docker Desktop installé et configuré
- Au moins 4 Go de RAM (8 Go recommandé)
- 20 Go d'espace disque disponible

## Configuration Docker Desktop

### 1. Activer WSL 2
- Assurez-vous que le sous-système Windows pour Linux (WSL 2) est activé.
- Installer une distribution Linux depuis le Microsoft Store (ex: Ubuntu).
- Configurer Docker Desktop pour utiliser WSL 2 comme moteur.

### 2. Configuration des ressources Docker
- Ouvrez Docker Desktop > Settings > Resources
- Allouez au moins 4 Go de RAM
- Allouez au moins 2 CPU

### 3. Partage des dossiers
- Assurez-vous que le dossier du projet est partagé avec Docker Desktop pour permettre le montage des volumes.

## Configuration réseau

### Autoriser les ports dans le pare-feu Windows
- Ouvrez le Pare-feu Windows > Paramètres avancés
- Créez des règles entrantes pour autoriser les ports suivants :
  - 8090 (HAProxy HTTP)
  - 8081 (Interface Web)
  - 8082 (Serveur Web 1)
  - 8083 (Serveur Web 2)
  - 3307 (HAProxy MySQL)

## Installation des dépendances

### 1. Ouvrir PowerShell en mode administrateur

### 2. Vérifier Docker
```powershell
docker --version
docker-compose --version
```

## Conseils
- Toujours exécuter Docker Desktop avant de lancer les conteneurs.
- Utiliser PowerShell ou CMD pour les commandes Docker.
- Si vous rencontrez des problèmes de permissions, essayez d'exécuter votre terminal en mode administrateur.

---

Votre environnement Windows est maintenant prêt pour déployer le projet avec Docker.
