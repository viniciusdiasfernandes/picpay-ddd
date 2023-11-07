drop database IF EXISTS picpay;
create database picpay;

create table if not exists picpay.user
(
    id bigint unsigned auto_increment primary key,
    name varchar(60) not null,
    last_name varchar(60) not null,
    document varchar(30) not null,
    email varchar(120) not null,
    password varchar(256) not null,
    type varchar(30) not null,
    balance float not null
);
