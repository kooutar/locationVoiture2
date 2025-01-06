# 🚗 **Drive & Loc - Système de Gestion de Location de Voitures**

## **Contexte du Projet**
L'agence **Drive & Loc** souhaite enrichir son site web en intégrant un module de gestion de location de voitures.  
L'objectif est de développer une plateforme créative et fonctionnelle en utilisant **PHP POO** et **SQL**, permettant aux clients de parcourir, réserver, et interagir avec les véhicules proposés.

---

## **Fonctionnalités**

### **Pour les Clients :**
1. **Connexion utilisateur :**  
   - Accès à la plateforme après authentification.

2. **Exploration des véhicules :**  
   - Parcourir les différentes catégories de véhicules disponibles.  
   - Filtrer les véhicules par catégorie sans rechargement de la page.  

3. **Détails des véhicules :**  
   - Visualiser les informations détaillées : modèle, prix, disponibilité, caractéristiques.

4. **Réservation de véhicules :**  
   - Réserver un véhicule en précisant les dates et lieux de prise en charge.

5. **Recherche avancée :**  
   - Rechercher un véhicule par son modèle ou ses caractéristiques.

6. **Avis et évaluations :**  
   - Ajouter un avis ou une évaluation après avoir loué un véhicule.  
   - Modifier ou supprimer ses propres avis (Soft Delete).

7. **Pagination :**  
   - **Version de base :** Pagination en PHP.  
   - **Version avancée :** Utilisation de **DataTable** pour une pagination dynamique et interactive.

---

### **Pour les Administrateurs :**
1. **Gestion des véhicules et catégories :**  
   - Ajouter plusieurs véhicules ou catégories en une seule opération (insertion en masse).  
   - Modifier ou supprimer les catégories et véhicules existants.

2. **Gestion des réservations et avis :**  
   - Superviser et gérer les réservations des clients.  
   - Valider ou supprimer les avis.

3. **Tableau de bord (Dashboard) :**  
   - Suivre les statistiques clés : nombre de réservations, catégories populaires, véhicules les mieux notés, etc.

---

## **Extras Techniques**

1. **Vue SQL "ListeVehicules" :**  
   - Combine les informations des véhicules, des catégories, des évaluations et de la disponibilité pour simplifier l'affichage.

2. **Procédure stockée "AjouterReservation" :**  
   - Facilite et sécurise le processus d'ajout d'une réservation avec les paramètres nécessaires (véhicule, dates, lieux).

---

## **Technologies Utilisées**
- **Back-end :** PHP POO, SQL  
- **Front-end :** HTML5, CSS3, JavaScript (avec intégration possible de **DataTable**)  
- **Base de données :** MySQL  

---

## **Installation et Lancement**

### **1. Pré-requis**
- Serveur local (Apache, Nginx) avec PHP installé (≥ 7.4).  
- Base de données MySQL.  
- Outils de gestion comme phpMyAdmin ou Adminer (facultatif).

### **2. Étapes d'installation**
1. Clonez ce dépôt sur votre machine locale :  
   ```bash
   git clone https://github.com/username/drive-and-loc.git
   cd drive-and-loc
