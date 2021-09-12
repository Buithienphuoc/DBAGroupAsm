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
create table branch
(
    branch_code    int          not null auto_increment,
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
create table customer_account
(
    id               int          not null auto_increment,
    phone            varchar(200) not null,
    first_name       varchar(200) not null,
    last_name        varchar(200) not null,
    email            varchar(200) not null,
    account_password varchar(200) not null,
    address          varchar(200) not null,
    city             varchar(200) not null,
    country          varchar(200) not null,
    budget           decimal      not null,
    balance          decimal      not null,
    profile_picture  varchar(200) not null,
    branch_id        int          null,
    constraint customer_account_id_uindex
        unique (id),
    constraint branch_id___fk
        foreign key (branch_id) references branch (branch_code)
);
create table auction_product
(
    id                        int          not null auto_increment,
    buyer_id                  int          null,
    product_name              varchar(50)  null,
    minimum_price             decimal      not null,
    closing_time              datetime     null,
    product_status            varchar(100) null,
    current_maximum_bid_price decimal      not null,
    seller_id                 int          null,
    constraint table_name_id_uindex
        unique (id),
    constraint auction_product_customer_account_id_fk
        foreign key (buyer_id) references customer_account (id),
    constraint seller_id_fk
        foreign key (seller_id) references customer_account (id)
);
alter table auction_product
    add primary key (id);
alter table customer_account
    add primary key (id);
create table transaction_history
(
    id          int auto_increment,
    product_id  int         not null,
    buyer_id    int         null,
    bid_price   decimal     null,
    recorded_at datetime    null,
    status      varchar(20) null,
    constraint table_name_id_uindex
        unique (id),
    constraint buyer__id_fk
        foreign key (buyer_id) references customer_account (id),
    constraint product_id___fk
        foreign key (product_id) references auction_product (id)
);
alter table transaction_history
    add primary key (id);
