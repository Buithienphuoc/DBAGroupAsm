create table auction_product
(
    id                        int          not null,
    product_name              varchar(50)  null,
    minimum_price             decimal      not null,
    closing_time              varchar(200) null,
    product_status            varchar(100) null,
    current_maximum_bid_price decimal      not null,
    seller_id                 int          null,
    constraint table_name_id_uindex
        unique (id),
    constraint seller_id_fk
        foreign key (seller_id) references customer_account (id)
);

alter table auction_product
    add primary key (id);