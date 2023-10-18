create database grafhy;
use grafhy;

CREATE TABLE users (
    user_id INT AUTO_INCREMENT PRIMARY KEY,
    user_name VARCHAR(255) NOT NULL,
    user_email VARCHAR(255) NOT NULL,
    user_pass VARCHAR(255) NOT NULL
);

CREATE TABLE solicitacoes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_name_recebe  VARCHAR(255) NOT NULL,
    user_name_envia VARCHAR(255) NOT NULL,
    data_hora DATETIME NOT NULL,
    situacao TINYINT NOT NULL
);

CREATE TABLE contatos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_name VARCHAR(50) NOT NULL,
    user_name1 VARCHAR(50) NOT NULL
);

CREATE TABLE chats (
    chat_id INT AUTO_INCREMENT PRIMARY KEY,
    chat_name VARCHAR(1000) NOT NULL,
    online_users INT NOT NULL,
    user_number INT NOT NULL
);

CREATE TABLE chat (
    mensagem_id INT AUTO_INCREMENT PRIMARY KEY,
    mensagem VARCHAR(5000) NOT NULL,
    data_hora VARCHAR(20) NOT NULL,
    user_name VARCHAR(100) NOT NULL
);

CREATE TABLE privado (
    mensagem_id INT AUTO_INCREMENT PRIMARY KEY,
    mensagem VARCHAR(5000) NOT NULL,
    data_hora VARCHAR(20) NOT NULL,
    contato VARCHAR(100) NOT NULL,
    user_name VARCHAR(100) NOT NULL
);

CREATE TABLE convites (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_name_recebe  VARCHAR(255) NOT NULL,
    user_name_envia VARCHAR(255) NOT NULL,
    grupo VARCHAR(255) NOT NULL,
    data_hora DATETIME NOT NULL
);

CREATE TABLE acessos(
    id INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
    user_name VARCHAR(50) NOT NULL,
    chat_name VARCHAR(50) NOT NULL
);

CREATE TABLE grupos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    grupo VARCHAR(1000) NOT NULL,
    online_users INT NOT NULL,
    user_number INT NOT NULL
);

CREATE TABLE mensagem_grupo (
    mensagem_id INT AUTO_INCREMENT PRIMARY KEY,
    mensagem VARCHAR(5000) NOT NULL,
    data_hora VARCHAR(20) NOT NULL,
    grupo VARCHAR(100) NOT NULL,
    user_name VARCHAR(100) NOT NULL
);

CREATE TABLE acessos_grupos(
    id INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
    user_name VARCHAR(50) NOT NULL,
    grupo VARCHAR(50) NOT NULL
);

create table visualizadas(
	id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
	user_name VARCHAR(255) NOT NULL,
	contato VARCHAR(255) NOT NULL,
	visualizadas INT NOT NULL
);

create table online_users(
    user_name VARCHAR(255) PRIMARY KEY NOT NULL,
    ultima DATETIME NOT NULL
);

create table perfil(
    user_name VARCHAR(255) PRIMARY KEY NOT NULL,
    recado VARCHAR(100) NOT NULL,
    arquivo varchar(100) NOT NULL,
    foto blob NOT NULL
);

CREATE TABLE pre_users (
    user_id INT AUTO_INCREMENT PRIMARY KEY,
    user_name VARCHAR(255) NOT NULL,
    user_email VARCHAR(255) NOT NULL,
    user_pass VARCHAR(255) NOT NULL
);