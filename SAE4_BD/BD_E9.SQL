DROP DATABASE IF EXISTS BD_E9;

CREATE DATABASE IF NOT EXISTS BD_E9;
USE BD_E9;
# -----------------------------------------------------------------------------
#       TABLE : AUTEUR
# -----------------------------------------------------------------------------

CREATE TABLE IF NOT EXISTS AUTEUR
 (
   ID_AUTEUR INTEGER NOT NULL AUTO_INCREMENT ,
   INTUITULEAUTEUR CHAR(32) NULL  
   , PRIMARY KEY (ID_AUTEUR) 
 ) 
 comment = "";

# -----------------------------------------------------------------------------
#       TABLE : LIVRE
# -----------------------------------------------------------------------------

CREATE TABLE IF NOT EXISTS LIVRE
 (
   ID_LIVRE INTEGER NOT NULL AUTO_INCREMENT ,
   LIBELLELANGUE CHAR(32) NOT NULL  ,
   ID_EDITEUR INTEGER NOT NULL  ,
   TITRE CHAR(255) NOT NULL  ,
   DESCRIPTION CHAR(255) NULL  ,
   COUVERTURE LONGBLOB NULL  ,
   DATEPARUTION DATE NULL  ,
   PAGE BIGINT(4) NULL  ,
   DATEACQUISITIONS DATE NOT NULL  
   , PRIMARY KEY (ID_LIVRE) 
 ) 
 comment = "";

# -----------------------------------------------------------------------------
#       INDEX DE LA TABLE LIVRE
# -----------------------------------------------------------------------------


CREATE  INDEX I_FK_LIVRE_LANGUE
     ON LIVRE (LIBELLELANGUE ASC);

CREATE  INDEX I_FK_LIVRE_EDITEUR
     ON LIVRE (ID_EDITEUR ASC);

# -----------------------------------------------------------------------------
#       TABLE : EMPRUNT
# -----------------------------------------------------------------------------

CREATE TABLE IF NOT EXISTS EMPRUNT
 (
   ID_EMPRUNT INTEGER NOT NULL AUTO_INCREMENT ,
   ID_LECTEUR INTEGER NOT NULL  ,
   ID_LIVRE INTEGER NOT NULL  ,
   DATEEMPRUNT DATETIME NOT NULL  ,
   DATERENDU DATETIME NULL  
   , PRIMARY KEY (ID_EMPRUNT) 
 ) 
 comment = "";

# -----------------------------------------------------------------------------
#       INDEX DE LA TABLE EMPRUNT
# -----------------------------------------------------------------------------


CREATE  INDEX I_FK_EMPRUNT_LECTEUR
     ON EMPRUNT (ID_LECTEUR ASC);

CREATE  INDEX I_FK_EMPRUNT_LIVRE
     ON EMPRUNT (ID_LIVRE ASC);

# -----------------------------------------------------------------------------
#       TABLE : CATEGORIE
# -----------------------------------------------------------------------------

CREATE TABLE IF NOT EXISTS CATEGORIE
 (
   NOMCATEGORIE CHAR(32) NOT NULL  
   , PRIMARY KEY (NOMCATEGORIE) 
 ) 
 comment = "";

# -----------------------------------------------------------------------------
#       TABLE : LECTEUR
# -----------------------------------------------------------------------------

CREATE TABLE IF NOT EXISTS LECTEUR
 (
   ID_LECTEUR INTEGER NOT NULL AUTO_INCREMENT ,
   NOMLECTEUR CHAR(32) NOT NULL  ,
   PRENOMLECTEUR CHAR(32) NOT NULL  ,
   IMAGEDEPROFIL LONGBLOB NULL  ,
   MOTDEPASSE CHAR(255) NOT NULL  ,
   EMAIL CHAR(255) NOT NULL  
   , PRIMARY KEY (ID_LECTEUR) 
 ) 
 comment = "";

# -----------------------------------------------------------------------------
#       TABLE : LANGUE
# -----------------------------------------------------------------------------

CREATE TABLE IF NOT EXISTS LANGUE
 (
   LIBELLELANGUE CHAR(32) NOT NULL  ,
   NOMLANGUE CHAR(32) NOT NULL  
   , PRIMARY KEY (LIBELLELANGUE) 
 ) 
 comment = "";

# -----------------------------------------------------------------------------
#       TABLE : EDITEUR
# -----------------------------------------------------------------------------

CREATE TABLE IF NOT EXISTS EDITEUR
 (
   ID_EDITEUR INTEGER NOT NULL AUTO_INCREMENT ,
   NOMEDITEUR CHAR(255) NOT NULL  
   , PRIMARY KEY (ID_EDITEUR) 
 ) 
 comment = "";

# -----------------------------------------------------------------------------
#       TABLE : SUIVRE
# -----------------------------------------------------------------------------

CREATE TABLE IF NOT EXISTS SUIVRE
 (
   ID_LECTEUR_SUIT INTEGER NOT NULL  ,
   ID_LECTEUR_EST_SUIVI INTEGER NOT NULL  
   , PRIMARY KEY (ID_LECTEUR_SUIT,ID_LECTEUR_EST_SUIVI) 
 ) 
 comment = "";

# -----------------------------------------------------------------------------
#       INDEX DE LA TABLE SUIVRE
# -----------------------------------------------------------------------------


CREATE  INDEX I_FK_SUIVRE_LECTEUR
     ON SUIVRE (ID_LECTEUR_SUIT ASC);

CREATE  INDEX I_FK_SUIVRE_LECTEUR1
     ON SUIVRE (ID_LECTEUR_EST_SUIVI ASC);

# -----------------------------------------------------------------------------
#       TABLE : ECRIRE
# -----------------------------------------------------------------------------

CREATE TABLE IF NOT EXISTS ECRIRE
 (
   ID_AUTEUR INTEGER NOT NULL  ,
   ID_LIVRE INTEGER NOT NULL  
   , PRIMARY KEY (ID_AUTEUR,ID_LIVRE) 
 ) 
 comment = "";

# -----------------------------------------------------------------------------
#       INDEX DE LA TABLE ECRIRE
# -----------------------------------------------------------------------------


CREATE  INDEX I_FK_ECRIRE_AUTEUR
     ON ECRIRE (ID_AUTEUR ASC);

CREATE  INDEX I_FK_ECRIRE_LIVRE
     ON ECRIRE (ID_LIVRE ASC);

# -----------------------------------------------------------------------------
#       TABLE : CATEGORISE
# -----------------------------------------------------------------------------

CREATE TABLE IF NOT EXISTS CATEGORISE
 (
   ID_LIVRE INTEGER NOT NULL  ,
   NOMCATEGORIE CHAR(32) NOT NULL  
   , PRIMARY KEY (ID_LIVRE,NOMCATEGORIE) 
 ) 
 comment = "";

# -----------------------------------------------------------------------------
#       INDEX DE LA TABLE CATEGORISE
# -----------------------------------------------------------------------------


CREATE  INDEX I_FK_CATEGORISE_LIVRE
     ON CATEGORISE (ID_LIVRE ASC);

CREATE  INDEX I_FK_CATEGORISE_CATEGORIE
     ON CATEGORISE (NOMCATEGORIE ASC);


# -----------------------------------------------------------------------------
#       CREATION DES REFERENCES DE TABLE
# -----------------------------------------------------------------------------


ALTER TABLE LIVRE 
  ADD FOREIGN KEY FK_LIVRE_LANGUE (LIBELLELANGUE)
      REFERENCES LANGUE (LIBELLELANGUE) ;


ALTER TABLE LIVRE 
  ADD FOREIGN KEY FK_LIVRE_EDITEUR (ID_EDITEUR)
      REFERENCES EDITEUR (ID_EDITEUR) ;


ALTER TABLE EMPRUNT 
  ADD FOREIGN KEY FK_EMPRUNT_LECTEUR (ID_LECTEUR)
      REFERENCES LECTEUR (ID_LECTEUR) ;


ALTER TABLE EMPRUNT 
  ADD FOREIGN KEY FK_EMPRUNT_LIVRE (ID_LIVRE)
      REFERENCES LIVRE (ID_LIVRE) ;


ALTER TABLE SUIVRE 
  ADD FOREIGN KEY FK_SUIVRE_LECTEUR (ID_LECTEUR_SUIT)
      REFERENCES LECTEUR (ID_LECTEUR) ;


ALTER TABLE SUIVRE 
  ADD FOREIGN KEY FK_SUIVRE_LECTEUR1 (ID_LECTEUR_EST_SUIVI)
      REFERENCES LECTEUR (ID_LECTEUR) ;


ALTER TABLE ECRIRE 
  ADD FOREIGN KEY FK_ECRIRE_AUTEUR (ID_AUTEUR)
      REFERENCES AUTEUR (ID_AUTEUR) ;


ALTER TABLE ECRIRE 
  ADD FOREIGN KEY FK_ECRIRE_LIVRE (ID_LIVRE)
      REFERENCES LIVRE (ID_LIVRE) ;


ALTER TABLE CATEGORISE 
  ADD FOREIGN KEY FK_CATEGORISE_LIVRE (ID_LIVRE)
      REFERENCES LIVRE (ID_LIVRE) ;


ALTER TABLE CATEGORISE 
  ADD FOREIGN KEY FK_CATEGORISE_CATEGORIE (NOMCATEGORIE)
      REFERENCES CATEGORIE (NOMCATEGORIE) ;

