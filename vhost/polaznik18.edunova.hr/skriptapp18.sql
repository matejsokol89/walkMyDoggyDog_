drop database if exists edunovapp18;
create database edunovapp18 character set utf8 collate utf8_general_ci;
# c:\xampp\mysql\bin\mysql -uedunova -pedunova --default_character_set=utf8 < "F:\vhost\predavac01.edunova.hr\skriptapp18.sql"
alter database edunovapp18 character set utf8 collate utf8_general_ci;
use edunovapp18;

 /**
     * 
     * 
     * Ako treba gledati vrijednosti parametara koji idu u bazu tada u my.ini (C:\xampp\mysql\bin)
     * u dijelu [mysqld] dodati (ili osloboditi - maknuti #)
     * #general_log_file = f:\mysqllog.log
     * #general_log      = 1
     * f:\mysqllog.log je datoteka gdje želite da piše - pripaziti ima li mysql ovlasti nad tom datotekom
     */

create table smjer(
sifra int not null primary key auto_increment,
naziv varchar(50) not null,
trajanje int not null,
cijena decimal(18,2) not null,
upisnina decimal(18,2) not null,
verificiran boolean not null
);

create table grupa(
	sifra 			int not null primary key auto_increment,
	naziv 			varchar(20) not null,
	smjer 			int,
	predavac 		int,
	brojpolaznika 	int,
	datumpocetka 	datetime 
);

create table predavac(
sifra int not null primary key auto_increment,
osoba int not null,
iban char(21)
);

create table osoba(
sifra int not null primary key auto_increment,
oib char(11),
ime varchar(50) not null,
prezime varchar(50) not null,
email varchar(100) not null
);


create table polaznik(
sifra int not null primary key auto_increment,
osoba int not null,
brojugovora varchar(50)
)engine=innodb;


create table clan(
grupa int not null,
polaznik int not null
);

alter table grupa add foreign key (smjer) references smjer(sifra);
alter table grupa add foreign key (predavac) references predavac(sifra);

alter table clan add foreign key (polaznik) references polaznik(sifra);
alter table clan add foreign key (grupa) references grupa(sifra);

alter table predavac add foreign key (osoba) references osoba(sifra);

alter table polaznik add foreign key (osoba) references osoba(sifra);

#loš
#1
insert into smjer values (null,'PHP programer',100,4999.99,500,false);

#bolji
#2
insert into smjer (naziv,trajanje,cijena,upisnina,verificiran) values
('Java programiranje',130,5900,350,true);


#bolji
#3
insert into smjer (upisnina,trajanje,cijena,naziv,verificiran) values
(400,130,2800,'Računalni operater',true);


#najbolji
#4
insert into smjer (sifra,naziv,trajanje,cijena,upisnina,verificiran) values
(null,'Računalni serviser',80,3600.00,450.00,false);



#1-18
insert into osoba (sifra,oib,ime,prezime,email) values
(null,null,'Tomislav','Jakopec','tjakopec@gmail.com'),
(null,null,'Josip','Dasović','josip.dasovic22@gmail.com'),
(null,null,'Robert','Zita','zitaa91@gmail.com'),
(null,null,'Darko','Klisurić','klisuric1995@gmail.com'),
(null,null,'Kristina','Terzić','kristina.terzic01@gmail.com'),
(null,null,'Željko','Livaja','zeljaos@gmail.com'),
(null,null,'Maja','Balaš','maja.balas@gmail.com'),
(null,null,'Leon','Mikić','leon.mikic93@gmail.com'),
(null,null,'Dino','Medić','dino.medic54@gmail.com'),
(null,null,'Ivan','Alošinac','alosinac111@gmail.com'),
(null,null,'Borna','Vrandečić','bornavrandecic@gmail.com'),
(null,null,'Filip','Jozić','filip.jozic@gmail.com'),
(null,null,'Tomislav','Glavaš','tomxjug2@gmail.com'),
(null,null,'Kristijan','Baro','baro.kristijan@gmail.com'),
(null,null,'Matej','Grgić','grgic.matej@gmail.com'),
(null,null,'Lorna','Tokić','tokiclorna31@gmail.com'),
(null,null,'Valentina','Milanović','v.milanovic22@gmail.com'),
(null,null,'Ivan','Šolić','aurumaureo@gmail.com');

#1
insert into predavac(sifra,osoba,iban) values
(null,1,null);

#1
insert into grupa(sifra,naziv,smjer,predavac,brojpolaznika,datumpocetka) values
(null,'PP18',1,1,20,'2018-10-29');

#1-17
insert into polaznik(sifra,osoba,brojugovora) values 
(null,2,null),(null,3,null),(null,4,null),(null,5,null),(null,6,null),(null,7,null),(null,8,null),(null,9,null),(null,10,null),(null,11,null),(null,12,null),(null,13,null),(null,14,null),(null,15,null),(null,16,null),(null,17,null),(null,18,null);


insert into clan(grupa,polaznik) values
(1,1),(1,2),(1,3),(1,4),(1,5),(1,6),(1,7),(1,8),(1,9),(1,10),(1,11),(1,12),(1,13),(1,14),(1,15),(1,16),(1,17);

create table operater(
	sifra int not null primary key auto_increment,
	ime varchar(50) not null,
	prezime varchar(50) not null,
	email varchar(100) not null,
	lozinka char(60) not null
);

insert into operater (ime,prezime,email,lozinka) values
(
	'Tomislav',
	'Jakopec',
	'tjakopec@gmail.com',
	'$2y$10$0oeK5JKlHslw1ksWLcimZOV2ggnEh5vltZq3ckemw4eIH79GYpTwi'

);


select 'Gotov sam';














