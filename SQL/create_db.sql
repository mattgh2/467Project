CREATE DATABASE IF NOT EXISTS `InventoryOrders`;
use `InventoryOrders`;

DROP TABLE IF EXISTS `Customer`;
DROP TABLE IF EXISTS `Orders`;
DROP TABLE IF EXISTS `Product`;
DROP TABLE IF EXISTS `OrderProduct`;

CREATE TABLE Customer (
    customerID INT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    customerName VARCHAR(25),
    email VARCHAR(35),
    addr VARCHAR(30)
);

CREATE TABLE Orders (
    orderID INT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    customerID INT UNSIGNED,
    orderDate DATE,
    orderStatus VARCHAR(50),
    FOREIGN KEY (customerID) REFERENCES Customer(customerID)
);

CREATE TABLE Product (
    productID INT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    productName VARCHAR(100),
    quantity INT
);

CREATE TABLE OrderProduct (
    orderID INT UNSIGNED,
    productID INT UNSIGNED,
    qty INT,
    PRIMARY KEY (orderID, productID),
    FOREIGN KEY (orderID) REFERENCES Orders(orderID),
    FOREIGN KEY (productID) REFERENCES Product(productID)
);