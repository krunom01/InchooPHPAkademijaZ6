DROP DATABASE IF EXISTS social_network;
CREATE DATABASE social_network CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
use social_network;

create table post(
id int not null primary key auto_increment,
content text,
cr_date timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
image LONGBLOB
);

create table comment (
id int not null primary key auto_increment,
content text not null,
cr_date timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
id_post int,
foreign key (id_post) references post(id) ON DELETE CASCADE
);


insert into post (content) values ('Evo danas pada kiša opet :('), ('Jedem jagode.'),('Jedesdfm jagode.');