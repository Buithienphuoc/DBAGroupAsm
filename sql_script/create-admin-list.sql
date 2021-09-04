create table admin_list
(
    id       int auto_increment
        primary key,
    username varchar(20) not null,
    password varchar(20) not null,
    constraint admin_list_password_uindex
        unique (password),
    constraint admin_list_username_uindex
        unique (username)
);

insert into admin_list (id, username, password) values (1, "admin", "admin");
