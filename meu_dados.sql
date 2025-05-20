-- Criar a base de dados
CREATE DATABASE IF NOT EXISTS meu_dados;
USE meu_dados;

-- Tabela Utilizadores
CREATE TABLE Utilizadores (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    apelido VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    telefone VARCHAR(15),
    nome_utilizador VARCHAR(100) NOT NULL UNIQUE,
    senha_encriptada VARCHAR(255) NOT NULL,
    função ENUM('admin', 'cliente', 'outro') NOT NULL DEFAULT 'cliente'
);

-- Tabela Notícias
CREATE TABLE Notícias (
    id INT AUTO_INCREMENT PRIMARY KEY,
    título VARCHAR(255) NOT NULL,
    resumo TEXT NOT NULL,
    conteúdo TEXT NOT NULL,
    data_publicação DATETIME DEFAULT CURRENT_TIMESTAMP,
    imagem VARCHAR(255) -- Caminho ou URL para a imagem
);

-- Tabela Clientes
CREATE TABLE Clientes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    apelido VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    telefone VARCHAR(15),
    nome_utilizador VARCHAR(100) NOT NULL UNIQUE,
    senha_encriptada VARCHAR(255) NOT NULL,
    função ENUM('cliente') NOT NULL DEFAULT 'cliente'
);

-- Tabela Projetos
CREATE TABLE Projetos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome_projeto VARCHAR(255) NOT NULL,
    descrição TEXT,
    tecnologia_utilizada VARCHAR(255),
    data_inicio DATE,
    data_fim DATE,
    imagem VARCHAR(255) -- Caminho ou URL para a imagem
);