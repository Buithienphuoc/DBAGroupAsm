/* Step 1: Create role */
CREATE ROLE 'customer','admin';

GRANT SELECT ON assignment_1.auction_product TO 'customer';
GRANT SELECT ON assignment_1.transaction_history TO 'customer';

GRANT ALL ON assignment_1.* TO 'admin';

CREATE USER 'fake_customer'@'localhost' IDENTIFIED BY '123456';

GRANT 'customer' TO 'fake_customer'@'localhost';

SET DEFAULT ROLE 'customer' to 'fake_customer'@'localhost';
