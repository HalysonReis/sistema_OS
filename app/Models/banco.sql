CREATE DATABASE sistema_os;
use sistema_os;

CREATE TABLE usuario(
	id_usuario int not null auto_increment,
    nome varchar(150),
    email varchar(150),
    senha varchar(12),
    tipo int default 0,
    status boolean default 1,
    data_cadastro datetime default current_timestamp,
    CONSTRAINT PRIMARY KEY (id_usuario)
);

CREATE TABLE cliente (
	id_cliente int not null auto_increment,
    endereco varchar(200),
    telefone char(16),
    id_usuario int,
    CONSTRAINT PRIMARY KEY (id_cliente),
    FOREIGN KEY (id_usuario) REFERENCES usuario(id_usuario)
);

CREATE TABLE ordem_servico (
	id_os int not null auto_increment,
    descricao varchar(255),
    status varchar(15),
    data_abertura datetime default current_timestamp,
    data_prevista datetime,
    data_entrega datetime,
    valor_total decimal(10,2),
    observacoes text,
    id_cliente int,
    CONSTRAINT PRIMARY KEY (id_os),
    FOREIGN KEY (id_cliente) REFERENCES cliente(id_cliente)
);

select 
cli.id_cliente, usu.nome, usu.email, usu.status, usu.data_cadastro, cli.endereco, cli.telefone 
from usuario usu 
inner join cliente cli 
on usu.id_usuario = cli.id_usuario;

select 
id_usuario, 
nome, 
email, 
tipo, 
status, 
data_cadastro 
from usuario;

select os.id_os, 
os.descricao, 
os.status, 
os.data_abertura, 
os.data_previta,
os.data_entrega, 
os.valor_total, 
os.observacoes, 
cli.telefone,
usu.nome
from ordem_servico os 
inner join cliente cli
on os.id_cliente = cli.id_cliente 
inner join usuario usu 
on cli.id_usuario = usu.id_usuario;

select 
id_usuario, 
nome, 
email, 
senha, 
tipo, 
status, 
data_cadastro 
from usuario
WHERE nome LIKE '%filtro%'
OR email LIKE '%filtro%';