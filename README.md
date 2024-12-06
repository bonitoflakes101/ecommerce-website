## How to Start

- **XAMPP** installed on your computer
- start both the **Apache** and **MySQL** services in XAMPP.

## Getting the Code

1. **Clone Repository:**

   - Open your terminal or command prompt.
   - Navigate to where you want to download our project.
   - Run this command (just replace `<your-github-repo-url>` with our repo link):
     ```bash
     git clone <your-github-repo-url>
     ```

2. **Move the Project Folder:**
   - Once cloned, find the folder named `ecommerce-website` and move it to your XAMPP `htdocs` directory.
   - It should look like this:
     ```
     C:\xampp\htdocs\ecommerce-website
     ```

## Setting Up the Database

1. **Open phpMyAdmin:**

   - In your web browser, go to `http://localhost/phpmyadmin`. This is where we manage our database.

2. **Create the Database:**

   - Click on the **Databases** tab at the top.
   - In the "Create database" field, type `ecommerce_db` and hit **Create**.

3. **Run the SQL Queries:**

   - Navigate to the **database_queries** folder in our cloned repository.
   - Open each SQL file inside, copy the code, and paste it into the SQL tab in phpMyAdmin.
   - Click **Go** to run the queries and set up our tables and some initial dummy data.

4. **Check Your Tables:**
   - Make sure the following tables are created and filled with data:
     - `Customer`
     - `Product`
     - `Order`
     - `OrderItem`
     - `Admin`
     - `Cart`
     - `CartItem`

## Connecting to the Database

1. **Find the Connection File:**

   - The database connection settings are in the `includes/db_config.php` file.

2. **Double-Check Your Connection Details:**

   - Make sure the following details match your setup:
     ```php
     $host = 'localhost';
     $db = 'ecommerce_db';
     $user = 'root'; // use your MySQL username if different
     $pass = ''; // add your MySQL password here if you have one
     $port = '3307'; // check that this matches the port in your XAMPP
     ```

3. **Test the Connection:**
   - Open `example.php` in your browser by going to `http://localhost/ecommerce-website/includes/example.php`.
   - you should see the page load without any errors.

## Setting Up PHPMailer for Email Sending

### 1. Install Composer
- Download Composer from [getcomposer.org](https://getcomposer.org/Composer-Setup.exe).
- Run the installer and follow the instructions.
- Ensure the installation path (e.g., `C:\ProgramData\ComposerSetup\bin`) is added to your system’s environment variables.

### 2. Verify Composer Installation
- Open a terminal and run:
  ```bash
  composer --version
  ```
- If Composer is installed correctly, it will display the installed version.

### 3. Install PHPMailer
- Navigate to the project root directory (where `composer.json` is located).
- Run the following command to install PHPMailer:
  ```bash
  composer require phpmailer/phpmailer
  ```


## Running the Application

1. **Access the Project:**
   - In your browser, go to `http://localhost/ecommerce-website/index.php` to view our main page.
