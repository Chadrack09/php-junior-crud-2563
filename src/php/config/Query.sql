-- Tables Creation
-- Description: This file contains the SQL queries to create the tables and insert the data into the database.

CREATE TABLE product_attributes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL UNIQUE,
    unit VARCHAR(255) NOT NULL
);

CREATE TABLE product_types (
    id INT AUTO_INCREMENT PRIMARY KEY,
    type VARCHAR(255) NOT NULL UNIQUE
);

CREATE TABLE product_type_attributes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    product_type_id INT NOT NULL,
    attribute_id INT NOT NULL,
    FOREIGN KEY (product_type_id) REFERENCES product_types(id) ON DELETE CASCADE,
    FOREIGN KEY (attribute_id) REFERENCES product_attributes(id) ON DELETE CASCADE
);

CREATE TABLE products (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    sku VARCHAR(255) NOT NULL UNIQUE,
    name VARCHAR(255) NOT NULL,
    price DECIMAL(10,2) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    type INT NOT NULL,
    FOREIGN KEY (type) REFERENCES product_types(id)
);


CREATE TABLE dvd (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    product_id INT(11) NOT NULL,
    size DECIMAL(10,2) NOT NULL,
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE
);

CREATE TABLE book (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    product_id INT(11) NOT NULL,
    weight DECIMAL(10,2) NOT NULL,
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE
);

CREATE TABLE furniture (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    product_id INT(11) NOT NULL,
    height DECIMAL(10,2) NOT NULL,
    width DECIMAL(10,2) NOT NULL,
    length DECIMAL(10,2) NOT NULL,
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE
);


-- Insert Product Attributes
INSERT INTO product_attributes (name, unit) VALUES ("size", "MB");
INSERT INTO product_attributes (name, unit) VALUES ("weight", "Kg");
INSERT INTO product_attributes (name, unit) VALUES ("height", "cm");
INSERT INTO product_attributes (name, unit) VALUES ("width", "cm");
INSERT INTO product_attributes (name, unit) VALUES ("length", "cm");

INSERT INTO product_types (type) VALUES ("DVD");
INSERT INTO product_types (type) VALUES ("Book");
INSERT INTO product_types (type) VALUES ("Furniture");

INSERT INTO product_type_attributes (product_type_id, attribute_id) VALUES (1, 1);
INSERT INTO product_type_attributes (product_type_id, attribute_id) VALUES (2, 2);
INSERT INTO product_type_attributes (product_type_id, attribute_id) VALUES (3, 3);
INSERT INTO product_type_attributes (product_type_id, attribute_id) VALUES (3, 4);
INSERT INTO product_type_attributes (product_type_id, attribute_id) VALUES (3, 5);

INSERT INTO products (sku, name, price, type) VALUES ('dvd001', 'The Shawshank Redemption', 19.99, 1);
INSERT INTO dvd (product_id, size) VALUES (LAST_INSERT_ID(), '4.7');

INSERT INTO products (sku, name, price, type) VALUES ('book001', 'To Kill a Mockingbird', '9.99', 2);
INSERT INTO book (product_id, weight) VALUES (LAST_INSERT_ID(), '0.5');

INSERT INTO products (sku, name, price, type) VALUES ('furniture001', 'Sofa', '499.99', 3);
INSERT INTO furniture (product_id, height, width, length) VALUES (LAST_INSERT_ID(), '1.8', '1.2', '0.8');

-- Another Insert Statements
INSERT INTO products (sku, name, price, type) VALUES ('dvd002', 'The Godfather', '14.99', 1);
INSERT INTO dvd (product_id, size) VALUES (LAST_INSERT_ID(), '4.3');

INSERT INTO products (sku, name, price, type) VALUES ('book002', 'The Catcher in the Rye', '8.99', 2);
INSERT INTO book (product_id, weight) VALUES (LAST_INSERT_ID(), '0.4');

INSERT INTO products (sku, name, price, type) VALUES ('furniture002', 'Dining Table', '799.99', 3);
INSERT INTO furniture (product_id, height, width, length) VALUES (LAST_INSERT_ID(), '0.7', '1.5', '2.2');

-- Another Insert Statements
INSERT INTO products (sku, name, price, type) VALUES ('dvd003', 'The Club of Three', '8.99', 1);
INSERT INTO dvd (product_id, size) VALUES (LAST_INSERT_ID(), '2.4');

INSERT INTO products (sku, name, price, type) VALUES ('book003', 'The Beast in The Jungle', '10.50', 2);
INSERT INTO book (product_id, weight) VALUES (LAST_INSERT_ID(), '0.2');

INSERT INTO products (sku, name, price, type) VALUES ('furniture003', 'Office Chair', '350.99', 3);
INSERT INTO furniture (product_id, height, width, length) VALUES (LAST_INSERT_ID(), '0.4', '1.0', '1.9');

-- Another Insert Statements
INSERT INTO products (sku, name, price, type) VALUES ('dvd004', 'Singing A Song', '12.85', 1);
INSERT INTO dvd (product_id, size) VALUES (LAST_INSERT_ID(), '10.4');

INSERT INTO products (sku, name, price, type) VALUES ('book004', 'Marry The Princess', '20.99', 2);
INSERT INTO book (product_id, weight) VALUES (LAST_INSERT_ID(), '0.8');

INSERT INTO products (sku, name, price, type) VALUES ('furniture004', 'Suit Case', '620.99', 3);
INSERT INTO furniture (product_id, height, width, length) VALUES (LAST_INSERT_ID(), '1.2', '0.3', '0.6');