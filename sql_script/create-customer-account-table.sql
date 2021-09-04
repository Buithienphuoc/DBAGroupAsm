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
    budget           decimal      not null,
    balance          decimal      not null,
    profile_picture  varchar(200) not null,
    branch_id        int          null,
    constraint customer_account_id_uindex
        unique (id),
    constraint branch_id___fk
        foreign key (branch_id) references branch (branch_code)
);

alter table customer_account
    add primary key (id);