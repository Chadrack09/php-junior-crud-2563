-- Tables Creation
-- Description: This file contains the SQL queries to create the tables and insert the data into the database.

CREATE TABLE product_attributes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL UNIQUE,
    unit VARCHAR(255) NOT NULL
);

CREATE TABLE product_types (
    id INT AUTO_INCREMENT PRIMARY KEY,
    type VARCHAR(255) NOT NULL UNIQUE,
    attribute_id INT NOT NULL,
    FOREIGN KEY (attribute_id) REFERENCES product_attributes(id) ON DELETE CASCADE
);

CREATE TABLE products (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    sku VARCHAR(255) NOT NULL UNIQUE,
    name VARCHAR(255) NOT NULL,
    price DECIMAL(10,2) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    -- type ENUM('DVD', 'Book', 'Furniture') NOT NULL,
    -- FOREIGN KEY (type) REFERENCES product_types(type) ON DELETE CASCADE
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
INSERT INTO product_attributes (name, unit) VALUES ('size', 'MB'), ('weight', 'Kg'), ('height', 'cm'), ('width', 'cm'), ('length', 'cm');
INSERT INTO product_types (type, attribute_id) VALUES ('DVD', 1), ('Book', 2), ('Furniture', 3);

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
