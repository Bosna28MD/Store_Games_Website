create database if not exists final_project_web;
use final_project_web;

create table if not exists user_table(
email varchar(256) not null,
name_user varchar(256),
age int,
pwd varchar(256) not null,
sum_points double(16,2) default 0.00,
primary key(email)
);

create table games_table_store(
id_game int not null auto_increment,
name_game varchar(256),
price double(16,2) default 0.00,
link_game varchar(256),
img_game varchar(256),
primary key(id_game)
);


insert into games_table_store(name_game,price,link_game,img_game) values('Tic-Tac-Toe',0.00,'tic_tac_toe.php','./img/tic_tac_toe_img.png'),
																		('Rock-Paper-Scissors',0.00,'rock_paper_scissor.php','./img/rock_paper_scissors_img.jpg'),
																		('Dinosaur',15.00,'dinosaur.php','./img/dinosaur_game.jpg'),
																		('Snake',50.00,'snake.php','./img/snake_img_game.jpg'),
																		('Ping-Pong',45.00,'ping_pong.php','./img/ping_pong_game_img.png');


create table if not exists tanzactie_table(
id_tranzactie int not null auto_increment,
id_game int ,
email varchar(256),
type_tranzac varchar(256) ,
sum_tranzac double(16,2),
number_check int default 1,
primary key(id_tranzactie)
);





