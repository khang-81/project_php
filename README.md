# 📱 PhoneShop - PHP Website

A modern and responsive e-commerce web application built using **PHP**, **MySQL**, **HTML/CSS**, and **JavaScript**. This project simulates a complete online mobile phone store where users can browse, search, view details, and purchase smartphones.

## 🚀 Features

### 🛍️ User Side

- 🧭 Home Page with featured products
- 🔍 Search and filter by name, brand, price
- 📄 Product detail pages
- 🛒 Shopping cart (Add, remove, update quantity)
- 🔐 User registration & login
- 💳 Order checkout and order history

### ⚙️ Admin Dashboard

- 🧑‍💼 Admin authentication
- 📦 Manage products (CRUD)
- 🧾 Manage orders and view order history
- 👤 Manage users
- 📊 Sales overview/dashboard

## 🛠️ Technologies Used

| Layer         | Technology             |
|---------------|------------------------|
| Frontend      | HTML5, CSS3, JavaScript, Bootstrap |
| Backend       | PHP (Vanilla PHP - no framework) |
| Database      | MySQL                  |
| Others        | FontAwesome, SweetAlert2, PHPMyAdmin |

## ⚙️ Setup Instructions

1. **Clone the Repository**

```bash
git clone https://github.com/khang-81/project_php.git
cd project_php
Import the Database

Open phpMyAdmin

Create a database, e.g., phoneshop

Import the SQL file located at /database/phoneshop.sql

Configure Database

Edit config/config.php and set your DB credentials:

define('DB_HOST', 'localhost');
define('DB_NAME', 'phoneshop');
define('DB_USER', 'root');
define('DB_PASS', '');
Run Locally

Use XAMPP or similar tool:

Start Apache and MySQL

Place project_php/ inside htdocs/

Access at: http://localhost/project_php

📄 License
This project is open-source and available under the MIT License.
