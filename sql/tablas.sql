create table categorias(
    id int auto_increment primary key,
    nombre varchar(20) not null unique,
    descripcion text
);

create table articulos(
    id int auto_increment primary key,
    nombre varchar(20) not null unique,
    disponible enum('SI', 'NO'),
    precio decimal(6,2),
    imagen varchar(120),
    category_id int not null,
    constraint fk_cat_art foreign key(category_id) references categorias(id) on delete cascade on update cascade
);