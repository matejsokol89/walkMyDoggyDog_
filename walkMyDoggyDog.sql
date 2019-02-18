drop database if exists walkMyDoggyDog;
create database walkMyDoggyDog character set utf8 collate utf8_general_ci;
# c:\xampp\mysql\bin\mysql -uedunova -pedunova --default_character_set=utf8 < f:\walkMyDoggyDog.sql
use walkMyDoggyDog;

create table vlasnik(
sifra int not null primary key auto_increment,
osoba int not null
);

create table iznajmljivac(
sifra int not null primary key auto_increment,
osoba int not null,
oglas int not null
);


create table osoba(
sifra int not null primary key auto_increment,
ime varchar(50) not null,
prezime varchar(50) not null,
email varchar(50) not null,
adresa varchar(50) not null,
mobitel int not null,
slika blob not null 
);

create table pas(
sifra int not null primary key auto_increment,
ime varchar(50) not null,
vrsta varchar(50) not null,
velicina varchar(50) not null,
slika blob not null,
vlasnik int not null
);

create table oglas(
sifra int not null primary key auto_increment,
naziv varchar(50) not null,
datumOglasa datetime,
slika blob not null,
aktivan boolean not null,
pas int not null
);

alter table vlasnik add foreign key (osoba) references osoba(sifra);
alter table iznajmljivac add foreign key (osoba) references osoba(sifra);
alter table pas add foreign key (vlasnik) references vlasnik(sifra);
alter table iznajmljivac add foreign key (oglas) references oglas(sifra);
alter table oglas add foreign key (pas) references pas(sifra);



