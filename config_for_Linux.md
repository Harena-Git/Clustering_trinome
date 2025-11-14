# Configuration requise pour Ubuntu

## Prérequis système
- Ubuntu 20.04 LTS ou supérieur
- Au moins 4 Go de RAM (8 Go recommandé)
- 20 Go d'espace disque disponible
- Accès root ou utilisateur avec droits sudo

## Installation des dépendances

### 1. Mise à jour du système
```bash
sudo apt update && sudo apt upgrade -y
```

### 2. Installation de Docker et Docker Compose
```bash
# Installer les paquets nécessaires
sudo apt install -y apt-transport-https ca-certificates curl software-properties-common

# Ajouter la clé GPG officielle de Docker
curl -fsSL https://download.docker.com/linux/ubuntu/gpg | sudo gpg --dearmor -o /usr/share/keyrings/docker-archive-keyring.gpg

# Ajouter le dépôt Docker
echo "deb [arch=amd64 signed-by=/usr/share/keyrings/docker-archive-keyring.gpg] https://download.docker.com/linux/ubuntu $(lsb_release -cs) stable" | sudo tee /etc/apt/sources.list.d/docker.list > /dev/null

# Mettre à jour les paquets et installer Docker
sudo apt update
sudo apt install -y docker-ce docker-ce-cli containerd.io

# Installer Docker Compose
sudo curl -L "https://github.com/docker/compose/releases/latest/download/docker-compose-$(uname -s)-$(uname -m)" -o /usr/local/bin/docker-compose
sudo chmod +x /usr/local/bin/docker-compose

# Vérifier l'installation
docker --version
docker-compose --version
```

### 3. Configuration du pare-feu (UFW)
```bash
# Installer UFW s'il n'est pas déjà installé
sudo apt install -y ufw

# Autoriser les ports nécessaires
sudo ufw allow 22/tcp        # SSH
sudo ufw allow 80/tcp        # HTTP
sudo ufw allow 443/tcp       # HTTPS
sudo ufw allow 8090/tcp      # HAProxy HTTP
sudo ufw allow 8081/tcp      # Interface Web
sudo ufw allow 8082/tcp      # Serveur Web 1
sudo ufw allow 8083/tcp      # Serveur Web 2
sudo ufw allow 3306/tcp      # MySQL
sudo ufw allow 3307/tcp      # HAProxy MySQL

# Activer le pare-feu
sudo ufw enable
```

### 4. Configuration de la mémoire pour MySQL (optionnel mais recommandé)
Si votre serveur a peu de mémoire, vous pourriez avoir besoin d'ajuster la configuration système pour MySQL :

```bash
# Éditer le fichier sysctl.conf
sudo nano /etc/sysctl.conf

# Ajouter ces lignes à la fin du fichier
vm.swappiness = 10
vm.vfs_cache_pressure = 50

# Appliquer les changements
sudo sysctl -p
```

## Configuration réseau

### Augmenter les limites de suivi de connexion
```bash
# Éditer les limites système
sudo nano /etc/sysctl.conf

# Ajouter ces lignes
net.netfilter.nf_conntrack_max = 131072
net.ipv4.netfilter.ip_conntrack_max = 131072

# Appliquer les changements
sudo sysctl -p
```

### Vérification de la configuration
Après avoir effectué ces étapes, redémarrez votre système pour appliquer tous les changements :
```bash
sudo reboot
```

Votre système Ubuntu est maintenant prêt pour le déploiement de l'infrastructure de clustering avec HAProxy, MySQL et les serveurs web.
