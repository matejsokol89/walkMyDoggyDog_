drop database if exists walkMyDoggyDog;
create database walkMyDoggyDog character set utf8 collate utf8_general_ci;
# c:\xampp\mysql\bin\mysql -uedunova -pedunova --default_character_set=utf8 < f:\walkMyDoggyDog.sql
use walkMyDoggyDog;

create table osoba(
sifra int not null primary key auto_increment,
ime varchar(50) not null,
prezime varchar(50) not null,
email varchar(50) not null,
adresa varchar(50) not null,
mobitel int not null,
slika varchar(50) not null
);

create table pas(
sifra int not null primary key auto_increment,
ime varchar(50) not null,
slika varchar(250) not null
);

create table vrsta(
sifra int not null primary key auto_increment,
vrsta varchar(50) not null,
velicina varchar(50) not null,
pas int not null
);


create table o_p(
osoba int not null,
pas int not null
);



create table oglas(
sifra int not null primary key auto_increment,
naziv varchar(50) not null,
datumOglasa datetime,
slika blob not null,
aktivan boolean not null,
pas int not null
);

create table operater(
	sifra int not null primary key auto_increment,
	ime varchar(50) not null,
	prezime varchar(50) not null,
	email varchar(100) not null,
	lozinka char(60) not null
);

insert into operater (ime,prezime,email,lozinka) values
(
	'Matej',
	'Sokol',
	'sokolvm@gmail.com',
	'$2y$10$0oeK5JKlHslw1ksWLcimZOV2ggnEh5vltZq3ckemw4eIH79GYpTwi'

);

insert into osoba (ime,prezime,email,adresa,mobitel,slika) values
(
	'Matej',
	'Sokol',
	'sokolvm@gmail.com',
	'Crkvena 61',
	0977137631,
	'slika'

);
insert into pas (ime,slika) values
(
	'Kika',
	'slika'
);




alter table oglas add foreign key (pas) references pas(sifra);
alter table vrsta add foreign key (pas) references pas(sifra);
alter table o_p add foreign key (pas) references pas(sifra);
alter table o_p add foreign key (osoba) references osoba(sifra);