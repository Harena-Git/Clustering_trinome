# EXPLAIN.md - Documentation du Projet de Clustering

## 📋 Vue d'Ensemble

Infrastructure de clustering avec **HAProxy** pour le load balancing, **MySQL Master-to-Master** pour la réplication, et **deux serveurs web PHP** démontrant la synchronisation des sessions.

## 🏗️ Architecture du Système


## 🌐 FICHIERS DES SERVEURS WEB

### 🏠 **index.php** (Page d'Accueil)
**Serveur 1** : Design bleu/violet • **Serveur 2** : Design rose/rouge

**Fonctionnalités :**
- ✅ Affichage IP et nom du serveur actuel
- ✅ Navigation vers les pages de test
- ✅ Design responsive avec cartes interactives
- ✅ Thème couleur unique par serveur

**Technologies :** PHP, CSS3 (Grid/Flexbox), HTML5

---

### 🍽️ **plat-preferer.php** (Test Sessions)
**Objectif :** Tester la synchronisation des sessions MySQL entre serveurs

**Fonctionnalités :**
- ✅ Formulaire d'enregistrement de plat préféré
- ✅ Stockage en session MySQL répliquée
- ✅ Affichage du contenu de la session
- ✅ Visualisation de l'ID de session

**Session Flow :** Formulaire → Session PHP → MySQL → Réplication → Autre serveur

---

### 📊 **server-info.php** (Monitoring Serveur)
**Dashboard technique complet**

**Informations affichées :**
- 🖥️ **Serveur** : IP, hostname, port, heure
- 👤 **Client** : IP, user agent, heure requête
- 💾 **Session** : ID, compteur visites, dernier accès
- ⚡ **Test Load Balancing** : Rafraîchissement manuel

**Utilisation :** Rafraîchir pour voir l'alternance HAProxy entre serveurs

---

### 🔧 **sessionHandler.php** (Gestionnaire Sessions)
**Implémentation custom de SessionHandlerInterface**

**Méthodes clés :**
```php
__construct()       // Connexion PDO à MySQL
read($id)          // Lecture session depuis DB
write($id, $data)  // Écriture session avec UPSERT
destroy($id)       // Suppression session
gc($maxlifetime)   // Nettoyage sessions expirées

