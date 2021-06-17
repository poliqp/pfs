create table scuole(id int auto_increment,nome varchar(50),codice_meccanografico varchar(10) unique,primary key(id));

create table plessi(id int auto_increment,id_scuola int not null,nome varchar(50),codice_meccanografico varchar(10),via varchar(30),primary key(id),foreign key(id_scuola) references scuole(id));

create table classi(id int auto_increment,id_plesso int not null,grado varchar(1) not null,sezione varchar(1) not null,primary key(id),foreign key(id_plesso) references plessi(id));

create table materie(id int auto_increment,nome varchar(20),primary key(id));

create table utenti(id int auto_increment,nome varchar(50) not null,cognome varchar(50) not null,username varchar(6) not null,codice_fiscale varchar(16) not null unique,data_nascita date not null,telefono_cellulare int not null unique,email varchar(50) not null unique,passwd varchar(64) not null,primary key(id));

create table professori(id int auto_increment,supplente boolean default false,id_utente int not null,primary key(id),foreign key(id_utente) references utenti(id));

create table genitori(id int auto_increment,id_utente int not null,primary key(id),foreign key(id_utente) references utenti(id));

create table studenti(id int auto_increment,id_utente int not null,id_classe int not null,id_genitore int,primary key(id),foreign key(id_utente) references utenti(id),foreign key(id_classe) references classi(id),foreign key(id_genitore) references genitori(id));

create table professori_classi_materie(id int not null auto_increment,id_professore int not null,id_plesso int not null,id_classe int not null,id_materia int not null,primary key(id),foreign key(id_professore) references professori(id),foreign key(id_plesso) references plessi(id),foreign key(id_materia) references materie(id),foreign key(id_classe) references classi(id));

create table giorni(id date not null,primary key(id));

/*MODIFICA SUL SERVER*/create table ore(id int auto_increment,id_classe int not null,foreign key(id_classe) references classi(id),primary key(id),ora varchar(1),id_giorno date not null,foreign key(id_giorno) references giorni(id),id_professore int not null,foreign key(id_professore) references professori(id),txt varchar(200) not null);

create table presenze(id int auto_increment,primary key(id),id_ora int not null,foreign key(id_ora) references ore(id),id_studente int not null,foreign key(id_studente) references studenti(id));

create table voti(id int auto_increment,primary key(id),id_professore int,foreign key(id_professore) references professori(id),id_studente int not null,foreign key(id_studente) references studenti(id),id_materia int,foreign key(id_materia) references materie(id),id_professore_classe_materia int,foreign key(id_professore_classe_materia) references professori_classi_materie(id),valore int not null,id_giorno date not null,foreign key(id_giorno) references giorni(id));

/*MODIFICA SUL SERVER*/create table compiti(id int auto_increment,primary key(id),giorno_scadenza date not null,id_professore int not null,foreign key(id_professore) references professori(id),id_classe int not null,foreign key(id_classe) references classi(id),txt varchar(50) not null);

create table note(id int auto_increment,primary key(id),id_professore int not null,foreign key(id_professore) references professori(id),id_classe int,foreign key(id_classe) references classi(id),id_studente int,foreign key(id_studente) references studenti(id),txt varchar(100));

create table messaggi(id int auto_increment,id_mittente int not null,id_destinatario int not null,testo varchar(300),primary key(id),foreign key(id_mittente) references utenti(id),foreign key(id_destinatario) references utenti(id));

create table incontri(id int auto_increment,id_genitore int not null,id_professore int not null,id_giorno date not null,primary key(id),foreign key(id_genitore) references genitori(id),foreign key(id_professore) references professori(id),foreign key(id_giorno) references giorni(id));


/*ELIMINATA*/create table professori_plessi(id int auto_increment,id_professore int not null,id_plesso int not null,primary key(id),foreign key(id_professore) references professori(id),foreign key(id_plesso) references plessi(id));
/*RETTIFICATA*/create table ore(id int auto_increment,id_professore_classe_materia int,id_giorno int not null,ora varchar(1) not null,primary key(id),foreign key(id_professore_classe_materia) references professori_classi_materie(id),foreign key(id_giorno) references giorni(id));


insert into scuole(nome,codice_meccanografico) values (?,?)
	insert into scuole(nome,codice_meccanografico) values ("Scuola nazionale","aaaaaaaaa1");
	insert into scuole(nome,codice_meccanografico) values ("Scuola tecnica","bbbbbbbbb1");

insert into plessi(nome,codice_meccanografico,via) values (?,?,?)
	insert into plessi(id_scuola,nome,codice_meccanografico,via) values (1,"Plesso A","aaaaaaaaa2","Via Ciao");
	insert into plessi(id_scuola,nome,codice_meccanografico,via) values (1,"Plesso B","aaaaaaaaa3","Via Arrivederci");
	insert into plessi(id_scuola,nome,codice_meccanografico,via) values (2,"Plesso C","bbbbbbbbb2","Via Ciaone");
	insert into plessi(id_scuola,nome,codice_meccanografico,via) values (2,"Plesso D","bbbbbbbbb3","Via Bella");

insert into classi(id_plesso,grado,sezione) values(?,?)
	insert into classi(id_plesso,grado,sezione) values(1,"4","N");
	insert into classi(id_plesso,grado,sezione) values(1,"5","N");
	insert into classi(id_plesso,grado,sezione) values(2,"2","P");
	insert into classi(id_plesso,grado,sezione) values(2,"3","P");

insert into materie(nome) values(?)
	insert into materie(nome) values("Informatica");
	insert into materie(nome) values("Matematica");
	insert into materie(nome) values("Inglese");
	insert into materie(nome) values("Italiano");
	insert into materie(nome) values("Disegno tecnico");
	insert into materie(nome) values("TPS");
	insert into materie(nome) values("Latino");

insert into utenti(nome,cognome,codice_fiscale,data_nascita,telefono_cellulare,email,passwd) values (?,?,?,?,?,?,?)
	insert into utenti(nome,cognome,username,codice_fiscale,data_nascita,telefono_cellulare,email,passwd) values ("Simone","Marietti","111111","aaaaaaaaaaaaaaaa","2001-03-23",333110333,"simone.marietti@gmail.com","2f30069bcce004a5588b49f89afbe6998e0fd76abf177ec65222f174e19eda50");      /* ID=1 STUDENTE */
	insert into utenti(nome,cognome,username,codice_fiscale,data_nascita,telefono_cellulare,email,passwd) values ("Mario","Barletta","222222","bbbbbbbbbbbbbbbb","1998-02-12",330333111,"mario.barletta2@gmail.com","2f30069bcce004a5588b49f89afbe6998e0fd76abf177ec65222f174e19eda50");	   /* ID=2 STUDENTE */
	insert into utenti(nome,cognome,username,codice_fiscale,data_nascita,telefono_cellulare,email,passwd) values ("Carlo","Sifoni","333333","cccccccccccccccc","1970-02-13",302333211,"carlo.sifoni2@gmail.com","2f30069bcce004a5588b49f89afbe6998e0fd76abf177ec65222f174e19eda50");           /* ID=3 PROFESSORE */
	insert into utenti(nome,cognome,username,codice_fiscale,data_nascita,telefono_cellulare,email,passwd) values ("Dante","Maroni","444444","dddddddddddddddd","1960-02-13",332330211,"dante.maroni3@gmail.com","2f30069bcce004a5588b49f89afbe6998e0fd76abf177ec65222f174e19eda50");           /* ID=4 PROFESSORE */
	insert into utenti(nome,cognome,username,codice_fiscale,data_nascita,telefono_cellulare,email,passwd) values ("Carlo","Sifoni","555555","eeeeeeeeeeeeeeee","1970-02-13",332033211,"carlo.sifoni6@gmail.com","2f30069bcce004a5588b49f89afbe6998e0fd76abf177ec65222f174e19eda50");           /* ID=5 PROFESSORE */
	insert into utenti(nome,cognome,username,codice_fiscale,data_nascita,telefono_cellulare,email,passwd) values ("Alessandro","Latini","666666","ffffffffffffffff","1968-02-13",332433211,"alessandro.latini1@gmail.com","2f30069bcce004a5588b49f89afbe6998e0fd76abf177ec65222f174e19eda50"); /* ID=6 PROFESSORE */
	insert into utenti(nome,cognome,username,codice_fiscale,data_nascita,telefono_cellulare,email,passwd) values ("Aldo","Barucci","777777","gggggggggggggggg","2004-09-18",342333251,"aldo.barucci@gmail.com","2f30069bcce004a5588b49f89afbe6998e0fd76abf177ec65222f174e19eda50");            /* ID=7 STUDENTE */
	insert into utenti(nome,cognome,username,codice_fiscale,data_nascita,telefono_cellulare,email,passwd) values ("Piero","Cardella","888888","hhhhhhhhhhhhhhhh","2001-05-13",382133211,"piero.cardella@gmail.com","2f30069bcce004a5588b49f89afbe6998e0fd76abf177ec65222f174e19eda50");        /* ID=8 STUDENTE */
	insert into utenti(nome,cognome,username,codice_fiscale,data_nascita,telefono_cellulare,email,passwd) values ("Mario","Barletta","999999","iiiiiiiiiiiiiiii","2005-02-12",332336211,"mario.barletta@gmail.com","2f30069bcce004a5588b49f89afbe6998e0fd76abf177ec65222f174e19eda50");        /* ID=9 STUDENTE */
	insert into utenti(nome,cognome,username,codice_fiscale,data_nascita,telefono_cellulare,email,passwd) values ("Carlo","Sifoni","A11111","llllllllllllllll","1970-02-13",332933211,"carlo.sifoni1@gmail.com","2f30069bcce004a5588b49f89afbe6998e0fd76abf177ec65222f174e19eda50");           /* ID=10 GENITORE */
	insert into utenti(nome,cognome,username,codice_fiscale,data_nascita,telefono_cellulare,email,passwd) values ("Piero","Sifoni","A22222","mmmmmmmmmmmmmmmm","1971-02-13",332333211,"piero.sifoni3@gmail.com","2f30069bcce004a5588b49f89afbe6998e0fd76abf177ec65222f174e19eda50");           /* ID=11 GENITORE */
	insert into utenti(nome,cognome,username,codice_fiscale,data_nascita,telefono_cellulare,email,passwd) values ("Marco","Ratteo","A33333","nnnnnnnnnnnnnnnn","1974-02-13",032333211,"marco.ratteo4@gmail.com","2f30069bcce004a5588b49f89afbe6998e0fd76abf177ec65222f174e19eda50");           /* ID=12 GENITORE */
	insert into utenti(nome,cognome,username,codice_fiscale,data_nascita,telefono_cellulare,email,passwd) values ("Piero","Antoni","A44444","oooooooooooooooo","1972-02-13",336323211,"piero.antoni1@gmail.com","2f30069bcce004a5588b49f89afbe6998e0fd76abf177ec65222f174e19eda50");           /* ID=13 GENITORE */

insert into professori(id_utente) values(?)
	insert into professori(id_utente) values(3);
	insert into professori(id_utente) values(4);
	insert into professori(id_utente) values(5);
	insert into professori(id_utente) values(6);

/*ELIMINATO*/ insert into professori_plessi(id_professore,id_plesso) values(?,?)
	insert into professori_plessi(id_professore,id_plesso) values(1,1);
	insert into professori_plessi(id_professore,id_plesso) values(2,1);
	insert into professori_plessi(id_professore,id_plesso) values(3,2);
	insert into professori_plessi(id_professore,id_plesso) values(2,2);
	insert into professori_plessi(id_professore,id_plesso) values(4,2);
	insert into professori_plessi(id_professore,id_plesso) values(3,3);
	insert into professori_plessi(id_professore,id_plesso) values(4,4);

insert into genitori(id_utente) values(?)
	insert into genitori(id_utente) values(10);
	insert into genitori(id_utente) values(11);
	insert into genitori(id_utente) values(12);
	insert into genitori(id_utente) values(13);

insert into studenti(id_utente,id_classe,id_genitore) values(?,?,?)
	insert into studenti(id_utente,id_classe,id_genitore) values(1,1,1);
	insert into studenti(id_utente,id_classe,id_genitore) values(2,1,2);
	insert into studenti(id_utente,id_classe,id_genitore) values(7,2,3);
	insert into studenti(id_utente,id_classe,id_genitore) values(8,2,4);
	insert into studenti(id_utente,id_classe,id_genitore) values(9,3,4);

insert into professori_classi_materie(id_professore,id_classe,id_materia) values (?,?,?)
	insert into professori_classi_materie(id_professore,id_classe,id_materia) values (1,1,1);
	insert into professori_classi_materie(id_professore,id_classe,id_materia) values (1,1,6);
	insert into professori_classi_materie(id_professore,id_classe,id_materia) values (2,1,2);
	insert into professori_classi_materie(id_professore,id_classe,id_materia) values (2,1,5);
	insert into professori_classi_materie(id_professore,id_classe,id_materia) values (4,1,3);
	insert into professori_classi_materie(id_professore,id_classe,id_materia) values (4,1,4);
	insert into professori_classi_materie(id_professore,id_classe,id_materia) values (4,1,7);
	insert into professori_classi_materie(id_professore,id_classe,id_materia) values (1,2,1);
	insert into professori_classi_materie(id_professore,id_classe,id_materia) values (1,2,6);
	insert into professori_classi_materie(id_professore,id_classe,id_materia) values (2,2,2);
	insert into professori_classi_materie(id_professore,id_classe,id_materia) values (2,2,5);
	insert into professori_classi_materie(id_professore,id_classe,id_materia) values (4,2,3);
	insert into professori_classi_materie(id_professore,id_classe,id_materia) values (4,2,4);
	insert into professori_classi_materie(id_professore,id_classe,id_materia) values (4,2,7);
	insert into professori_classi_materie(id_professore,id_classe,id_materia) values (3,3,1);
	insert into professori_classi_materie(id_professore,id_classe,id_materia) values (3,3,2);
	insert into professori_classi_materie(id_professore,id_classe,id_materia) values (1,3,4);
	insert into professori_classi_materie(id_professore,id_classe,id_materia) values (3,3,7);
	insert into professori_classi_materie(id_professore,id_classe,id_materia) values (3,4,1);


QUERY

1)Select genitori.id from genitori inner join incontri on genitori.id=incontri.id_genitori right join genitori on genitori.id=genitori.id inner join studenti on a.id=studenti.id_genitore where incontri.id is null AND studenti.id = ANY (Select studenti.id from studenti inner join voti on studenti.id=voti.id group by studenti having avg(voti) < 6);

2)Select count(*) from note_studenti inner join studenti on note_studenti.id_studente=studenti.id inner join classi on studenti.id_classe=classi.id group by classi