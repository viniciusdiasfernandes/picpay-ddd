drop database IF EXISTS picpay;
create database picpay;

create table if not exists picpay.account
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

create table if not exists picpay.transaction
(
    id bigint unsigned auto_increment primary key,
    amount float not null,
    sender_id               bigint unsigned not null,
    constraint payment_sender_id_foreign
    foreign key (sender_id) references account (id),
    receiver_id               bigint unsigned not null,
    status varchar(30) not null,
    constraint payment_receiver_id_foreign
    foreign key (receiver_id) references account (id),
    timestamp int not null
)
