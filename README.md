# 📚 Online Book Store Project
## 🌟 Overview
This is a PHP-based web application for managing an online book store. The application includes features for users to browse, search, and purchase products, as well as roles for administrators and editors to manage various aspects of the store. The project integrates with the Billplz payment gateway using a sandbox emulator for demonstration purposes.
## ✨ Features
### 👥 User Roles and Permissions
1. **Normal User** 👤:
   - Can search for products by keywords or filter by categories.
   - Can add products to the cart, update the cart, and make payments via Billplz sandbox emulator.
   - Can check their cart and view their orders.
2. **Editor** ✏️:
   - Can manage products (CRUD operations, set as trending, and set in-stock status).
   - Can manage authors.
   - Can manage categories.
   - Has access to the dashboard page.
   - Cannot place orders.
3. **Admin** 👑:
   - Can perform all actions available to the editor.
   - Can manage user accounts.
   - Can manage messages sent via the contact form.
   - Can manage orders and update order statuses.
   - Receives emails from the contact form (sent to the shop owner's email).
   - Cannot place orders.
### 🎯 General Features
- **Dashboard Page** 📊 (accessible by Editors and Admins):
  - Displays recent orders.
  - Shows new account sign-ups.
  - Provides total amount for sales, products, categories, and authors.
- **Contact Form** 📧:
  - Allows users to send messages to the shop owner.
  - Emails are sent to the shop owner's configured email address.
- **Product Browsing** 🔍:
  - Users can search for products and filter them by categories.
## 🚀 Installation
1. Clone the repository:
   ```bash
   git clone <repository-url>
   ```
2. Set up the database by importing the provided SQL file.
3. Configure environment variables.
   ```bash
   // create config.php file in root directory ..
   <?php
    define('LOCAL_DB_PASSWORD', ...);
    define('DB_HOST', ...);
    define('DB_NAME', ...);
    define('DB_USER', ...);
    define('DB_PASSWORD', ...);
    define('MAILGUN_API_URL', ...);
    define('MAILGUN_API_KEY', ...);
    define('MAILGUN_RECEIVER', EMAIL_RECEIVER_EMAIL);
    define('BILLPLZ_API_URL', 'https://www.billplz-sandbox.com/api/');
    define('BILLPLZ_COLLECTION_ID', ...);
    define('BILLPLZ_API_KEY', ...);
    define('BILLPLZ_X_SIGNATURE', ...);
   ?>
   ```
4. Start the server using your preferred method (In my case, I'm using Docker & DevKinsta).

## 🔧 Dependencies
- PHP
- MySQL
- Billplz API (sandbox mode used for testing)
- Mailgun API (for contact form emails)

## 📖 Usage
1. **Normal Users** 👤:
   - Search for products and register or log in to add item to cart and place orders.
2. **Editors** ✏️:
   - Log in to manage products, authors, and categories.
   - Access the dashboard for store analytics.
3. **Admins** 👑:
   - Log in to manage all aspects of the store, including user accounts and orders.
  
## 📸 Screenshot
Home Page             |  Admin Dashboard Page
:-------------------------:|:-------------------------:
![User Home Page](https://github.com/user-attachments/assets/49a5825b-7534-4f5b-9341-541d2e2964c2)  |  ![Admin Dashboard Page](https://github.com/user-attachments/assets/81779363-cd74-4441-81de-84c0bcb02571)

## 📝 Notes
- This project is currently set up to use sandbox APIs for both Billplz and Mailgun.
- Ensure that API keys and other sensitive information are securely stored and not hardcoded in the application.
