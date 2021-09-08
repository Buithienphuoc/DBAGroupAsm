CREATE TABLE branch (
    branch_code INT NOT NULL,
    branch_name VARCHAR(200) NOT NULL,
    address VARCHAR(200) NOT NULL,
    hotline_number VARCHAR(200) NOT NULL,
    CONSTRAINT branch_branch_code_uindex UNIQUE (branch_code),
    CONSTRAINT branch_branch_name_uindex UNIQUE (branch_name)
);

alter table branch
    add primary key (branch_code);

/*create auction product table*/

CREATE TABLE customer_account (
    id INT NOT NULL AUTO_INCREMENT,
    phone VARCHAR(200) NOT NULL,
    first_name VARCHAR(200) NOT NULL,
    last_name VARCHAR(200) NOT NULL,
    email VARCHAR(200) NOT NULL,
    account_password VARCHAR(200) NOT NULL,
    address VARCHAR(200) NOT NULL,
    city VARCHAR(200) NOT NULL,
    country VARCHAR(200) NOT NULL,
    budget DECIMAL NOT NULL,
    balance DECIMAL NOT NULL,
    profile_picture VARCHAR(200) NOT NULL,
    branch_id INT NULL,
    CONSTRAINT branch_id___fk FOREIGN KEY (branch_id)
        REFERENCES branch (branch_code),
    CONSTRAINT customer_account_id_uindex UNIQUE (id)
);

alter table customer_account
    add primary key (id);


CREATE TABLE auction_product (
    id INT NOT NULL AUTO_INCREMENT,
    minimum_price DECIMAL NOT NULL,
    closing_time VARCHAR(200) NULL,
    product_status VARCHAR(100) NULL,
    current_maximum_bid_price DECIMAL NOT NULL,
    seller_id INT NULL,
    product_name VARCHAR(200) NOT NULL,
    CONSTRAINT table_name_id_uindex UNIQUE (id),
    CONSTRAINT seller_id_fk FOREIGN KEY (seller_id)
        REFERENCES customer_account (id)
);

alter table auction_product
    add primary key (id);


/*create customer transaction history table*/

CREATE TABLE transaction_history (
    id INT NOT NULL AUTO_INCREMENT,
    product_id INT NOT NULL,
    buyer_id INT NULL,
    bid_price DECIMAL NULL,
    recorded_at DATETIME NULL,
    CONSTRAINT table_name_id_uindex UNIQUE (id),
    CONSTRAINT buyer__id_fk FOREIGN KEY (buyer_id)
        REFERENCES customer_account (id),
    CONSTRAINT product_id___fk FOREIGN KEY (product_id)
        REFERENCES auction_product (id)
);

alter table transaction_history
    add primary key (id);