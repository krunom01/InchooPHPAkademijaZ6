DROP DATABASE IF EXISTS polaznik16_mvc;
CREATE DATABASE polaznik16_mvc CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
use polaznik16_mvc;

create table post(
id int not null primary key auto_increment,
content text,
cr_date timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
image LONGBLOB
)engine=InnoDB;

create table comment (
id int not null primary key auto_increment,
content text not null,
cr_date timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
id_post int,
foreign key (id_post)
references post(id) ON DELETE CASCADE
)engine=InnoDB;

