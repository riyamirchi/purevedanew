-- Create the database
CREATE DATABASE IF NOT EXISTS pureveda;

-- Use the database
USE pureveda;

-- Table to store user details (customers and admins)
CREATE TABLE IF NOT EXISTS users (
    user_id INT(11) AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    phone VARCHAR(15) NOT NULL,
    address TEXT NOT NULL,
    role ENUM('user', 'admin') DEFAULT 'user'
);

-- Table to store product categories
CREATE TABLE IF NOT EXISTS categories (
    category_id INT(11) AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL
);

-- Table to store products
CREATE TABLE IF NOT EXISTS products (
    product_id INT(11) AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    description TEXT NOT NULL,
    price DECIMAL(10,2) NOT NULL,
    image VARCHAR(255) NOT NULL,
    stock INT(11) NOT NULL,
    category_id INT(11) NOT NULL,
    FOREIGN KEY (category_id) REFERENCES categories(category_id)
);

-- Table to store orders
CREATE TABLE IF NOT EXISTS orders (
    order_id INT(11) AUTO_INCREMENT PRIMARY KEY,
    user_id INT(11) NOT NULL,
    total_price DECIMAL(10,2) NOT NULL,
    order_status ENUM('pending', 'completed', 'shipped') DEFAULT 'pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(user_id)
);

-- Table to store items in an order
CREATE TABLE IF NOT EXISTS order_items (
    order_item_id INT(11) AUTO_INCREMENT PRIMARY KEY,
    order_id INT(11) NOT NULL,
    product_id INT(11) NOT NULL,
    quantity INT(11) NOT NULL,
    price DECIMAL(10,2) NOT NULL,
    FOREIGN KEY (order_id) REFERENCES orders(order_id),
    FOREIGN KEY (product_id) REFERENCES products(product_id)
);

-- Table to store items in the shopping cart
CREATE TABLE IF NOT EXISTS cart (
    cart_id INT(11) AUTO_INCREMENT PRIMARY KEY,
    user_id INT(11) NOT NULL,
    product_id INT(11) NOT NULL,
    quantity INT(11) NOT NULL,
    FOREIGN KEY (user_id) REFERENCES users(user_id),
    FOREIGN KEY (product_id) REFERENCES products(product_id)
);

-- cart
                        CREATE DATABASE shopping_cart;

                        USE shopping_cart;

                        CREATE TABLE users (
                            id INT AUTO_INCREMENT PRIMARY KEY,
                            username VARCHAR(50) NOT NULL,
                            password VARCHAR(255) NOT NULL
                        );

                        CREATE TABLE products (
                            id INT AUTO_INCREMENT PRIMARY KEY,
                            name VARCHAR(255) NOT NULL,
                            price DECIMAL(10, 2) NOT NULL,
                            description TEXT,
                            stock INT DEFAULT 0
                        );

                        CREATE TABLE cart (
                            id INT AUTO_INCREMENT PRIMARY KEY,
                            user_id INT NOT NULL,
                            product_id INT NOT NULL,
                            quantity INT DEFAULT 1,
                            FOREIGN KEY (user_id) REFERENCES users(id),
                            FOREIGN KEY (product_id) REFERENCES products(id)
                        );
                        -- Insert some sample products
                        INSERT INTO products (name, price, description, stock) VALUES
                        ('Product 1', 10.00, 'Description for product 1', 50),
                        ('Product 2', 15.00, 'Description for product 2', 30),
                        ('Product 3', 20.00, 'Description for product 3', 20);


                       

