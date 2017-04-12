create table account (username varchar(30) NOT NULL PRIMARY KEY, password varchar (30));

create table media (filename varchar(40), username varchar(40), type varchar(30), mediaid int NOT NULL AUTO_INCREMENT PRIMARY KEY, path varchar(100), description varchar(1000), title varchar(50));

create table tags(media int NOT NULL, tag varchar(30), tagid int NOT NULL AUTO_INCREMENT PRIMARY KEY);
