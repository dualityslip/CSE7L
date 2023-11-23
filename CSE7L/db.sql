create database if not exists tms;

use tms;

create table if not exists tasks (
    taskId int auto_increment primary key,
    taskName varchar(255) not null,
    is_done boolean default 0,
    userId int 
);

create table if not exists users (
    userId int auto_increment primary key,
    name varchar(255) not null
);
