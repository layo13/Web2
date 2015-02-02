DROP DATABASE IF EXISTS web2;

CREATE DATABASE IF NOT EXISTS web2;
USE web2;
# -----------------------------------------------------------------------------
#       TABLE : fabricant
# -----------------------------------------------------------------------------

CREATE TABLE IF NOT EXISTS fabricant
 (
   id INTEGER(2) NOT NULL AUTO_INCREMENT ,
   nom VARCHAR(64) NOT NULL  
   , PRIMARY KEY (id) 
 ) 
 comment = "";

# -----------------------------------------------------------------------------
#       TABLE : CHANGEMENT_ETAT
# -----------------------------------------------------------------------------

CREATE TABLE IF NOT EXISTS changement_etat
 (
   date DATETIME NOT NULL  ,
   equipement CHAR(8) NOT NULL  ,
   etat_fonctionnel INTEGER(2) NULL  ,
   etat_technique INTEGER(2) NULL  ,
   type INTEGER(2) NOT NULL  ,
   message TEXT NULL  
   , PRIMARY KEY (date, equipement) 
 ) 
 comment = "";

# -----------------------------------------------------------------------------
#       INDEX DE LA TABLE CHANGEMENT_ETAT
# -----------------------------------------------------------------------------

CREATE  INDEX I_FK_CHANGEMENT_ETAT_type_changement
     ON changement_etat (type ASC);

CREATE  INDEX I_FK_CHANGEMENT_ETAT_EQUIPEMENT
     ON changement_etat (equipement ASC);

# -----------------------------------------------------------------------------
#       TABLE : type_equipement
# -----------------------------------------------------------------------------

CREATE TABLE IF NOT EXISTS type_equipement
 (
   id INTEGER(2) NOT NULL AUTO_INCREMENT ,
   libelle VARCHAR(64) NOT NULL  
   , PRIMARY KEY (id) 
 ) 
 comment = "";

# -----------------------------------------------------------------------------
#       TABLE : etat_technique
# -----------------------------------------------------------------------------

CREATE TABLE IF NOT EXISTS etat_technique
 (
   id INTEGER(2) NOT NULL AUTO_INCREMENT ,
   libelle VARCHAR(64) NOT NULL  
   , PRIMARY KEY (id) 
 ) 
 comment = "";

# -----------------------------------------------------------------------------
#       TABLE : etat_fonctionnel
# -----------------------------------------------------------------------------

CREATE TABLE IF NOT EXISTS etat_fonctionnel
 (
   id INTEGER(2) NOT NULL AUTO_INCREMENT ,
   libelle VARCHAR(64) NOT NULL  
   , PRIMARY KEY (id) 
 ) 
 comment = "";

# -----------------------------------------------------------------------------
#       TABLE : type_changement
# -----------------------------------------------------------------------------

CREATE TABLE IF NOT EXISTS type_changement
 (
   id INTEGER(2) NOT NULL AUTO_INCREMENT ,
   libelle VARCHAR(64) NOT NULL  
   , PRIMARY KEY (id) 
 ) 
 comment = "";

# -----------------------------------------------------------------------------
#       TABLE : EQUIPEMENT
# -----------------------------------------------------------------------------

CREATE TABLE IF NOT EXISTS equipement
 (
   id CHAR(8) NOT NULL  ,
   pere CHAR(8) NULL  ,
   etat_technique INTEGER(2) NOT NULL  ,
   etat_fonctionnel INTEGER(2) NOT NULL  ,
   fabricant INTEGER(2) NOT NULL  ,
   type INTEGER(2) NOT NULL  ,
   nom VARCHAR(255) NOT NULL  ,
   adresse_ip CHAR(15) NULL  ,
   adresse_physique VARCHAR(64) NULL  ,
   message_maintenance VARCHAR(255) NULL  ,
   numero_support CHAR(10) NULL  ,
   utilisateur CHAR(64) NULL  
   , PRIMARY KEY (id) 
 ) 
 comment = "";

# -----------------------------------------------------------------------------
#       INDEX DE LA TABLE equipement
# -----------------------------------------------------------------------------


CREATE  INDEX I_FK_EQUIPEMENT_EQUIPEMENT
     ON equipement (pere ASC);

CREATE  INDEX I_FK_EQUIPEMENT_etat_technique
     ON equipement (etat_technique ASC);

CREATE  INDEX I_FK_EQUIPEMENT_etat_fonctionnel
     ON equipement (etat_fonctionnel ASC);

CREATE  INDEX I_FK_EQUIPEMENT_FABRICANT
     ON equipement (fabricant ASC);

CREATE  INDEX I_FK_EQUIPEMENT_type_equipement
     ON equipement (type ASC);


# -----------------------------------------------------------------------------
#       CREATION DES REFERENCES DE TABLE
# -----------------------------------------------------------------------------

ALTER TABLE changement_etat 
  ADD FOREIGN KEY FK_CHANGEMENT_ETAT_EQUIPEMENT (equipement)
      REFERENCES equipement (id) ;


ALTER TABLE changement_etat 
  ADD FOREIGN KEY FK_CHANGEMENT_ETAT_etat_technique (etat_technique)
      REFERENCES etat_technique (id) ;


ALTER TABLE changement_etat 
  ADD FOREIGN KEY FK_CHANGEMENT_ETAT_etat_fonctionnel (etat_fonctionnel)
      REFERENCES etat_fonctionnel (id) ;


ALTER TABLE equipement 
  ADD FOREIGN KEY FK_EQUIPEMENT_EQUIPEMENT (pere)
      REFERENCES equipement (id) ;


ALTER TABLE equipement 
  ADD FOREIGN KEY FK_EQUIPEMENT_etat_technique (etat_technique)
      REFERENCES etat_technique (id) ;


ALTER TABLE equipement 
  ADD FOREIGN KEY FK_EQUIPEMENT_etat_fonctionnel (etat_fonctionnel)
      REFERENCES etat_fonctionnel (id) ;


ALTER TABLE equipement 
  ADD FOREIGN KEY FK_EQUIPEMENT_FABRICANT (fabricant)
      REFERENCES fabricant (id) ;


ALTER TABLE equipement 
  ADD FOREIGN KEY FK_EQUIPEMENT_type_equipement (type)
      REFERENCES type_equipement (id) ;


INSERT INTO `web2`.`etat_technique` (`libelle`) VALUES ('Fonctionnel'), ('En panne mineure'), ('En panne majeure'), ('Inconnu');
INSERT INTO `web2`.`etat_fonctionnel` (`libelle`) VALUES ('En marche'), ('Eteint'), ('En arrêt de maintenance');
INSERT INTO `web2`.`fabricant` (`nom`) VALUES ('Asus'), ('Dell'), ('Cisco'), ('Canon'), ('Samsung'), ('Lexmark');
INSERT INTO `web2`.`type_equipement` (`libelle`) VALUES ('Ordinateur fixe'), ('Ordinateur portable'), ('Imprimante'), ('Photocopieuse'), ('Téléphone'), ('Routeur'), ('Serveur');
INSERT INTO `web2`.`type_changement` (`libelle`) VALUES ('Ajout de matériel'), ('Modification des propriétés'), ('Changement d\'état fonctionnel'), ('Changement d\'état technique');