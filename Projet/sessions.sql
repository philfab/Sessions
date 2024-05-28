CREATE DATABASE IF NOT EXISTS Sessions;
USE Sessions;

CREATE TABLE formateur(
   id_formateur INT,
   nom VARCHAR(50) NOT NULL,
   prenom VARCHAR(50) NOT NULL,
   email VARCHAR(100) NOT NULL,
   PRIMARY KEY(id_formateur)
);

CREATE TABLE stagiaire(
   id_stagiaire INT,
   nom VARCHAR(50) NOT NULL,
   prenom VARCHAR(50) NOT NULL,
   dateNaissance DATE NOT NULL,
   sexe TINYINT NOT NULL,
   email VARCHAR(100) NOT NULL,
   ville VARCHAR(30) NOT NULL,
   telephone VARCHAR(50) NOT NULL,
   PRIMARY KEY(id_stagiaire)
);

CREATE TABLE categorie(
   id_categorie INT,
   nom VARCHAR(50) NOT NULL,
   PRIMARY KEY(id_categorie)
);

CREATE TABLE user(
   id_user INT,
   pseudo VARCHAR(50) NOT NULL,
   email VARCHAR(50) NOT NULL,
   password VARCHAR(255) NOT NULL,
   roles VARCHAR(30) NOT NULL,
   PRIMARY KEY(id_user)
);

CREATE TABLE session(
   id_session INT,
   intitule VARCHAR(255) NOT NULL,
   dateDebut DATE NOT NULL,
   dateFin DATE NOT NULL,
   nbPlacesTotales INT NOT NULL,
   formateur_id INT NOT NULL,
   PRIMARY KEY(id_session),
   FOREIGN KEY(formateur_id) REFERENCES formateur(id_formateur) ON DELETE CASCADE
);

CREATE TABLE module(
   id_module INT,
   titre VARCHAR(255) NOT NULL,
   categorie_id INT NOT NULL,
   PRIMARY KEY(id_module),
   FOREIGN KEY(categorie_id) REFERENCES categorie(id_categorie) ON DELETE CASCADE
);

CREATE TABLE programme(
   id_programme INT,
   nbJours INT NOT NULL,
   session_id INT NOT NULL,
   module_id INT NOT NULL,
   PRIMARY KEY(id_programme),
   FOREIGN KEY(session_id) REFERENCES session(id_session) ON DELETE CASCADE,
   FOREIGN KEY(module_id) REFERENCES module(id_module) ON DELETE CASCADE
);

CREATE TABLE inscrire(
   id_session INT,
   id_stagiaire INT,
   PRIMARY KEY(id_session, id_stagiaire),
   FOREIGN KEY(id_session) REFERENCES Session(id_session) ON DELETE CASCADE,
   FOREIGN KEY(id_stagiaire) REFERENCES stagiaire(id_stagiaire) ON DELETE CASCADE
);
