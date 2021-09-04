create table transaction_history
(
    id          int      not null,
    product_id  int      not null,
    buyer_id    int      null,
    bid_price   decimal  null,
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