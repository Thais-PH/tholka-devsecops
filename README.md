# MyDigitalStartup - Industrialisation DevSecOps 🚀

## 📝 Contexte
Ce projet s'inscrit dans le cadre de l'évaluation du module **DevSecOps** (M2 DFS).
L'objectif est d'industrialiser l'application « MyDigitalStartup » en intégrant la sécurité dès la conception (Shift Left) et en automatisant le déploiement.

---

## 🏗️ Architecture & Stack Technique

### Application
- **Frontend** : Nuxt.js (Vue 3)
- **Backend** : Drupal 10 (PHP 8.3)
- **Base de données** : MariaDB 10.6

### Pipeline CI/CD (GitHub Actions)
Le pipeline est défini dans `.github/workflows/ci.yml` et comprend les étapes suivantes :
1.  **Sécurité (DevSec)** :
    -   🕵️‍♂️ **Gitleaks** : Détection de secrets dans le code.
    -   📦 **Trivy (FS)** : Scan de vulnérabilités dans les dépendances (SCA).
    -   🔍 **SonarQube** : Analyse qualité et sécurité du code (SAST).
2.  **Intégration Continue (CI)** :
    -   🏗️ Build & Lint du Frontend (Node.js).
    -   🐘 Installation & Validation du Backend (Composer).
3.  **Containerisation & Sécurité Image** :
    -   🐳 Construction de l'image Docker optimisée (Multi-stage build).
    -   🛡️ **Trivy (Image)** : Scan de l'image finale avant déploiement.

---

## 💻 Installation & Démarrage Local

Pour lancer le projet sur votre machine (nécessite Docker & Docker Compose) :

```bash
# 1. Cloner le dépôt
git clone https://github.com/Thais-PH/tholka-devsecops.git
cd tholka-devsecops

# 2. Lancer les conteneurs
docker-compose up -d --build

# 3. Accéder à l'application
# Frontend : http://localhost:3000 (ou port défini dans docker-compose)
# Backend  : http://localhost:8080
```

---

## 🛡️ Stratégie de Sécurité

- **Scan de Code (SAST)** : SonarQube est utilisé pour identifier les "Code Smells" et failles potentielles.
- **Scan de Dépendances (SCA)** : Trivy analyse les paquets NPM et Composer pour détecter les CVE connues.
- **Scan de Conteneurs** : Trivy scanne l'image Docker finale pour s'assurer qu'aucune vulnérabilité système n'est embarquée.
- **Secrets** : Gitleaks empêche le commit accidentel de clés API ou mots de passe.

---

## 🔄 Procédure de Rollback

En cas d'échec de mise en production ou de bug critique, voici la procédure de retour arrière :

1.  **Identifier la version stable précédente** (via les Tags Git ou l'historique des commits).
2.  **Revert via Git** :
    ```bash
    git revert HEAD  # Annule le dernier commit
    git push origin master
    ```
    *Cela déclenchera automatiquement le pipeline CI/CD pour redéployer la version précédente.*
3.  **Rollback manuel (si le pipeline est HS)** :
    Se connecter au serveur et déployer l'image Docker précédente :
    ```bash
    ssh user@vps-ip
    cd /app
    docker-compose pull # ou spécifier le tag précédent
    docker-compose up -d
    ```

---

## 👥 Auteur
Projet réalisé par Thais-PH pour le module DevSecOps.
