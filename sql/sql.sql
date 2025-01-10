create database Drive;
use Drive;
create table role(
   idrole int primary key NOT NULL AUTO_INCREMENT,
  titre  varchar(255) 
);
insert into role(titre) value('client');
insert into role(titre) value('admin');

create table utilisateur(
    iduser int primary key NOT NULL AUTO_INCREMENT,
    nom varchar(20) NOT NULL,
    Email varchar(20) not NULL unique,
    telephone varchar(20) not null ,
    date_Naissance date ,
    gender Enum('male','Femme'),
    password varchar(255) not null,
    idrole int not NULL,
    foreign key(idrole) references role(idrole)
);
 create table categorie(
    idCategorie int primary key NOT NULL AUTO_INCREMENT,
    nom varchar(100) not NUll Unique,
    description Text
 );
 create table vehicule(
    idVehicule int primary key NOT NULL AUTO_INCREMENT,
    idCategorie int NOT NULL NOT NULL,
     prix decimal(10,2) not NULL,
     disponsible bool default false,
     path_image varchar(255) NOT NULL,
     lieu varchar(50) NOT NULL,
     nom varchar(255),
     foreign key (idCategorie) references categorie(idCategorie)
 );

 create table reservation(
      date_debut date not null,
      date_fin  date NOT NULL,
      status ENUM('en attente','accepte','refuse') default 'en attente',
      iduser int not NULL,
      idVehicule int NOT NULL,
      foreign key (iduser) references utilisateur(iduser),
      foreign key (idVehicule) references vehicule(idVehicule),
      primary key (iduser,idVehicule)
 );

CREATE TABLE avis (
      idAvis INT AUTO_INCREMENT PRIMARY KEY,
      commentaire TEXT NOT NULL,
      note INT CHECK (note BETWEEN 1 AND 5), 
      iduser INT NOT NULL,
      idVehicule INT NOT NULL,
      FOREIGN KEY (iduser, idVehicule) REFERENCES reservation(iduser, idVehicule)
);
ALTER TABLE vehicule ADD nom varchar(255)  ;

create view vehicule_categorie as 
select v.* ,c.nom as nomcategorie , c.idCategorie as idcategorieCcategorie ,c.description
from vehicule v
inner join categorie c
on v.idCategorie=c.idCategorie;

-- verifire si modifiable
SELECT IS_UPDATABLE 
FROM INFORMATION_SCHEMA.VIEWS 
WHERE TABLE_NAME = 'vehicule_categorie';

DELIMITER //
create PROCEDURE AjouterReservation (
   IN id_uder int,
   IN id_vehicule int,
   IN date_debut date,
   In date_fin date
  
)
BEGIN
INSERT INTO reservation(iduser,idVehicule,date_debut,date_fin)
VALUES(id_uder,id_vehicule,date_debut,date_fin);
Update vehicule
set disponsible=true
WHERE idVehicule=id_vehicule;
END;//



create view avis_user as
select avi.* , u.nom
from avis avi
inner join utilisateur u
on avi.iduser=u.iduser 


-- vertion 2
create table utilisateur(
    iduser int primary key NOT NULL AUTO_INCREMENT,
    nom varchar(20) NOT NULL,
    Email varchar(20) not NULL unique,
    telephone varchar(20) not null ,
    date_Naissance date ,
    gender Enum('male','Femme'),
    password varchar(255) not null,
    idrole int not NULL,
    foreign key(idrole) references role(idrole)
);
CREATE TABLE Article (
    id INT AUTO_INCREMENT PRIMARY KEY,
    titre VARCHAR(255),
    contenu TEXT,
    path_image varchar(255),
    iduser INT,
    idtag INT
    FOREIGN KEY (iduser) REFERENCES utilisateur(iduser) ON DELETE CASCADE,
    FOREIGN KEY (idtag) REFERENCES tag(id) ON DELETE CASCADE
);

CREATE TABLE Favorie (
    id INT AUTO_INCREMENT PRIMARY KEY,
    iduser INT,
    articleId INT,
    dateAjout DATETIME,
    FOREIGN KEY (iduser) REFERENCES utilisateur(iduser) ON DELETE CASCADE,
    FOREIGN KEY (articleId) REFERENCES Article(id) ON DELETE CASCADE
);

create table commentaire(
    id INT AUTO_INCREMENT PRIMARY KEY,
    commentaire text NOT NULL,
    clientId INT,
     articleId INT,
      FOREIGN KEY (clientId) REFERENCES utilisateur(iduser) ON DELETE CASCADE,
    FOREIGN KEY (articleId) REFERENCES Article(id) ON DELETE CASCADE
);

create table tag(
   id INT AUTO_INCREMENT PRIMARY KEY,
   tag varchar(255)
);
create table tag_article(
   idtag int NOT NULL,
   id_article int NOT NULL,
   idtheme int ,
   FOREIGN KEY (idtag) REFERENCES tag(id) ON DELETE CASCADE,
   FOREIGN KEY (id_article) REFERENCES Article(id) ON DELETE CASCADE,
    FOREIGN KEY (idtheme) REFERENCES theme(idtheme) ON DELETE CASCADE
);
create table theme(
   idtheme INT AUTO_INCREMENT PRIMARY KEY,
   theme varchar(255)
);

ALTER TABLE Article
ADD idtag INT, -- Ajout de la colonne idtag
ADD CONSTRAINT fk_idtag FOREIGN KEY (idtag) REFERENCES tag(id) ON DELETE CASCADE;

ALTER TABLE Article
ADD idtheme int, 
ADD CONSTRAINT fk_idtheme FOREIGN KEY (idtheme) REFERENCES theme(idtheme) ON DELETE CASCADE;

DELETE from Article colume idtag


CREATE OR REPLACE view allArticle as 
select a.* , t.tag
from Article a 
inner join tag_article a_t 
on a.id= a_t.id_article
inner join tag t 
on a_t.idtag= t.id;
group by (id);


select t.tag
from tag t
inner join tag_article a_t
on t.id=a_t.idtag
WHERE a_t.id_article=18;


TRUNCATE TABLE tag_article;

select a.*  
from Article a
inner join tag_article a_t 
on a.id= a_t.id_article
inner join tag t 
on a_t.idtag= t.id;


select t.tag
from tag t
inner join tag_article a_t
on a_t.idtag= t.id;

Alter table Article
add column status enum ('en attente', 'acceptee', 'refusee')  default 'en attente'