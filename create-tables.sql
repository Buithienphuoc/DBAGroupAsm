create schema assignment_1;

/*create branch product table*/

create table branch
(
    branch_code    int          not null,
    branch_name    varchar(200) not null,
    address        varchar(200) not null,
    hotline_number varchar(200) not null,
    constraint branch_branch_code_uindex
        unique (branch_code),
    constraint branch_branch_name_uindex
        unique (branch_name)
);

alter table branch
    add primary key (branch_code);

/*create auction product table*/

create table auction_product
(
    id                        int          not null,
    minimum_price             decimal       not null,
    closing_time              varchar(200) null,
    product_status            varchar(100) null,
    current_maximum_bid_price decimal       not null,
    seller_id   int          null,
    constraint table_name_id_uindex
        unique (id),
    constraint seller_id_fk
        foreign key (seller_id) references customer_account (id)
);

alter table auction_product
    add primary key (id);

/*create customer account table*/

create table customer_account
(
    id               int          not null,
    phone            varchar(200) not null,
    first_name       varchar(200) not null,
    last_name        varchar(200) not null,
    email            varchar(200) not null,
    account_password varchar(200) not null,
    address          varchar(200) not null,
    city             varchar(200) not null,
    country          varchar(200) not null,
    budget           decimal       not null,
    balance          decimal       not null,
    profile_picture  varchar(200) not null,
    branch_id   int          null,
    constraint branch_id___fk
        foreign key (branch_id) references branch (branch_code),
    constraint customer_account_id_uindex
        unique (id)
);

alter table customer_account
    add primary key (id);

/*create customer transaction history table*/

create table transaction_history
(
    id          int          not null,
    product_id  int          not null,
    buyer_id    int          null,
    bid_price   decimal       null,
    recorded_at datetime null,
    constraint table_name_id_uindex
        unique (id),
    constraint buyer__id_fk
        foreign key (buyer_id) references customer_account (id),
    constraint product_id___fk
        foreign key (product_id) references auction_product (id)
);

alter table transaction_history
    add primary key (id);
    
drop table if exists branch;
drop table if exists auction_product;    
drop table if exists customer_account;
drop table if exists transaction_history;

insert into branch (branch_code, branch_name, address, hotline_number)
values 
(3753, 'Laptop/Computer', '45-4, Nagata-cho 2-chome, Chiyoda-ku, Tokyo', '+8170-162-6220'),
(9488, 'TV', '3200 Clifford Street, Concord, California', '510-697-9932'),
(7555, 'Phone' '813-6, Hannam-dong, Yongsan-gu, Seoul', '+82-1-621-8419'),
(7999, 'Camera', 'Via Belviglieri 107, Roma', '0372 0788675');

insert into auction_product (id, minimum_price, closing_time, product_status, current_maximum_bid_price, seller_id)
values 
(1, 60.37, '16:00', 'Active', 85.13, 5),
(2, 96.20, '13:00', 'Active', 133.57, 6),
(3, 85.13, '12:00', 'Active', 52.86, 7),
(4, 69.49, '21:00', 'Active', 67.36, 8);

insert into customer_account (id, phone, first_name, last_name, email, account_password, address, city, country, budget, balance, profile_picture, branch_id)
values 
(1, '+8139-346-0840', 'Nobuko', 'Yagi', 'Nobuko@mail.com', '461908', '470-1148, Oichiharacho, Izumiotsu-shi, Osaka', 'Osaka', 'Japan', 89.57, 186.15, 'https://res.cloudinary.com/dfsxndngi/image/upload/v1629967406/Database%20Applications%20Images/118264959_126999029111111_7190628552647179067_n_ngzxuk.jpg', 1),
(2, '904-480-5838', 'Charlie', 'Fernandez', 'Charlie@mail.com', '061306', '4472 Arrowood Drive, Orlando, Florida', 'Florida', 'USA', 73.14, 200.35, 'https://res.cloudinary.com/dfsxndngi/image/upload/v1629967641/Database%20Applications%20Images/depositphotos_39258143-stock-illustration-businessman-avatar-profile-p_wxf0t5.jpg', 2),
(3, '+82-2-285-5596', 'Ji', 'Pak', 'Ji@mail.com', '389755', '297-10, Yeomchang-dong, Gangseo-gu, Seoul', 'Seoul', 'Korea', 84.25, 186.15, 'https://res.cloudinary.com/dfsxndngi/image/upload/v1629967428/Database%20Applications%20Images/181964622_193748319232088_6294252897318227780_n_dn943l.jpg', 3),
(4, '0394 4316429', 'Emanuele', 'Folliero', 'Emanuele@mail.com', '902416', 'Via dei Fiorentini 65, Napoli', 'Napoli', 'Italy', 69.04, 189.19, 'https://res.cloudinary.com/dfsxndngi/image/upload/v1629967684/Database%20Applications%20Images/69-691026_emo-boys-images-boys-cool-stylish-facebook-profile_obuimk.jpg', 4),
(5, '+8179-124-7504', 'Yasuhiro', 'Hada', 'Yasuhiro@mail.com', '184094', '243-1255, Nishishinjuku Shinjuku Sumitomobiru(28-kai), Shinjuku-ku, Tokyo', 'Tokyo', 'Japan', 91.28, 198.93, 'https://res.cloudinary.com/dfsxndngi/image/upload/v1629967662/Database%20Applications%20Images/user-avatar_gz8obv.png', 1),
(6, '320-650-2631', 'Baldwin', 'Robson', 'Baldwin@mail.com', '247326', '4755 Brighton Circle Road, Saint Cloud, Minnesota', 'Minnesota', 'USA', 94.86, 179.29, 'https://res.cloudinary.com/dfsxndngi/image/upload/v1629967706/Database%20Applications%20Images/pexels-photo-771742_xkexva.jpg', 2),
(7, '+82-4-292-8600', 'Mun-Hee', 'An', 'Mun-Hee@mail.com', '455395', '225-1, Hyeondaeapateu, Ganseog 4(sa)-dong, Namdong-gu, Incheon', 'Incheon', 'Korea', 85.86, 174.21, 'https://res.cloudinary.com/dfsxndngi/image/upload/v1629967483/Database%20Applications%20Images/photo-1520635360276-79f3dbd809f6_rutc8y.jpg', 3),
(8, '0314 6594092', 'Gregario' 'Ferri', 'Gregario@gmail.com', '794545', 'Via Antonio Cecchi 1037, Venezia', 'Venezia', 'Italy', 81.34, 197.56, 'https://res.cloudinary.com/dfsxndngi/image/upload/v1629967780/Database%20Applications%20Images/Anime-Boys-Drawception-Profile_egzoq3.jpg', 4);

insert into transaction_history (id, product_id, buyer_id, bid_price, recorded_at)
values 
(1, 1, 1, 32.30, 2021-11-11),
(2, 2, 2, 41.66, 2021-12-21),
(3, 3, 3, 26.04, 2022-05-21),
(4, 4, 4, 20.63, 2022-01-31);
