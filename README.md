# 🛍️ Site de Vente en Ligne – Projet SAÉ – IUT de Lannion

Ce projet est un site web de gestion de produits, développé dans le cadre de ma formation à l’IUT de Lannion. Il permet d’ajouter, modifier, supprimer et consulter des objets via une interface web simple, simulant un mini site de vente en ligne.

## 🎯 Objectifs du projet

- Concevoir un site dynamique de gestion de produits
- Implémenter les opérations CRUD (Create, Read, Update, Delete)
- Interfacer le site avec une base de données
- Gérer l’affichage, l’ajout et la suppression d’images produits
- Proposer une interface utilisateur claire et fonctionnelle

## 🛠️ Technologies utilisées

- **PHP** – Back-end et logique serveur
- **HTML/CSS** – Structure et design du site
- **JavaScript** – Comportements dynamiques
- **SQLite** – Base de données légère embarquée
- **Apache** – Serveur local (via XAMPP ou WAMP)

## 🚀 Fonctionnalités principales

- ➕ **Ajout de produit** (`insertion.php`)
- 📝 **Modification** (`modification.php`)
- 🗑️ **Suppression** (`suppression.php`)
- 👀 **Affichage de tous les produits** (`listeProduits.php`)
- 🖼️ **Gestion d’images** associées aux objets

## 📁 Structure du projet

SAé/
├── index.php # Accueil
├── insertion.php # Ajout d’un produit
├── modification.php # Modification de produit
├── suppression.php # Suppression de produit
├── listeProduits.php # Affichage de la liste des produits
├── connexion.php # Connexion à la base SQLite
├── fonctions.php # Fonctions PHP réutilisables
├── formulaires.php # Formulaires HTML
├── image.php # Gestion des images
├── css/ # Styles CSS
├── js/ # JavaScript
├── images/ # Images uploadées
├── bdd/ # Dossier contenant la base SQLite
└── acces.log # Log d’accès (utile pour debug)


## 💡 Installation

1. Cloner ou télécharger ce dépôt.
2. Placer le dossier `SAé/` dans le dossier `htdocs` de XAMPP ou `www` de WAMP.
3. Lancer le serveur Apache + SQLite.
4. Accéder au site via `http://localhost/SAé/index.php`.

## ⚠️ Remarques

- Le site est prévu pour fonctionner **localement**.
- Les images sont stockées sur le serveur et référencées dans la base de données.

---
