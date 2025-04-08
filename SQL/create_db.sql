CREATE TABLE Customer (
    customerID INT PRIMARY KEY,
    customerName VARCHAR(100),
    email VARCHAR(100),
    address VARCHAR(255)
);

CREATE TABLE Orders (
    orderID INT PRIMARY KEY AUTO_INCREMENT,
    customerID INT,
    orderDate DATE,
    status VARCHAR(50),
    FOREIGN KEY (customerID) REFERENCES Customer(customerID)
);

CREATE TABLE Product (
    productID INT PRIMARY KEY,
    productName VARCHAR(100),
    quantity INT
);

CREATE TABLE OrderProduct (
    orderID INT,
    productID INT,
    qty INT,
    PRIMARY KEY (orderID, productID),
    FOREIGN KEY (orderID) REFERENCES Orders(orderID),
    FOREIGN KEY (productID) REFERENCES Product(productID)
);