# DBAGroupAsm
DBAGroupAsm Instructions

## Demo video Group 20 Project YouTube Video Link: https://youtu.be/GuX08AZpktw

How to setup the project:
1. Drop the database you are using for developing the group project with your group members.
2. Create a database from scratch and name whatever you like.
3. Copy SQL script in "creation-tables.sql" in the sql_script folder into the SQL schema that you have created. Then, execute it to create the required tables.
4. Import Fake data from sql_script/fake_data folder into the tables that you have created in MySQL Workbench.

How to run the server:
1. Open Command Prompt and start the server through running the WAMP and typing "php -S localhost:8000". In addition, you have to go to the project folder before you run the server.
2. You have to change the dbname to assignment_1 and mysqlpassword to none.

How to use the Online Auction System (Customer):
1. Go to login.php page and use any account you have in customer_account SQL table.
2. Create an auction.
3. Go to "View auctions" to place a bid.
4. Go to "My won bid" to see the results.
5. Go to "Bid history" to view the list of all the bids you made in the past.

How to use the Online Auction System (Administrator):
1. In a login.php page, click the "Admin login" to log in as an administrator.
   1.1 The default account is: 
   username = admin, 
   password = admin 
   Which you just added minutes ago in the admin_list table
   1.2 Admin account cannot be created by customer, there is no need registration form for customer
   
3. Go to "Update Customer's balance" to update the balance for one customer.
4. Go to "View all tranactions and Calculate total bid price" to view list of all transactions and calculate the total bid price of all the transactions.
5. Go to "Make product INACTIVE to create transactions" to check if any products are inactive or update their details.
6. Go to "View and undo transaction" to view the list of transactions and undo any of them if necessary.

## Contributions: Everyone have the same contributions