# CodeIgniter 3 Phonebook System

A simple Phonebook CRUD application built with CodeIgniter 3 and MySQL. Users can add, edit, delete (single or bulk), search, sort, and filter contacts by status or region.

---

## 📋 Features

- **Create / Read / Update / Delete** contacts
- **Bulk delete** via checkbox selection
- **Search** by Name or Phone (free text)
- **Filter** by Status (active/inactive) or Region (multi-select)
- **Sort** by newest, oldest, or alphabetical Name
- **Responsive** Bootstrap 5 frontend with custom color palette
- **50-record seed** SQL script for testing

---

## 🛠️ Tech Stack

- **Framework:** CodeIgniter 3
- **Language:** PHP 7+
- **Database:** MySQL / MariaDB
- **Frontend:** Bootstrap 5, vanilla JavaScript

---

## ⚙️ Prerequisites

- PHP 7.2 or higher
- MySQL or MariaDB
- XAMPP / WAMP / LAMP stack

---

## 🚀 Installation

1. **Clone or unzip** into your web root:
   ```bash
   # If using Git:
   git clone https://github.com/yourusername/phonebook-ci3.git C:/xampp/htdocs/phonebook

   # Or unzip:
   Unzip phonebook_ci3.zip → C:/xampp/htdocs/phonebook
   ```

2. **Create the database**
   ```sql
   CREATE DATABASE phonebook_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
   ```

3. **Import seed data**
   - Run the provided `seed_contacts.sql` (50 test records) in your `phonebook_db`.

4. **Configure CodeIgniter**
   - **Base URL** in `application/config/config.php`:
     ```php
     $config['base_url'] = 'http://localhost/phonebook/';
     ```
   - **Autoload** in `application/config/autoload.php`:
     ```php
     $autoload['libraries'] = ['database', 'form_validation', 'session'];
     $autoload['helper']    = ['url', 'form'];
     ```
   - **Database** in `application/config/database.php`:
     ```php
     $db['default'] = [
       'hostname' => 'localhost',
       'username' => 'root',
       'password' => '',
       'database' => 'phonebook_db',
       'dbdriver' => 'mysqli',
       // ... other defaults ...
     ];
     ```

5. **Remove `index.php` from URLs** *(optional)*
   - Place `.htaccess` in `phonebook/`:
     ```apacheconf
     <IfModule mod_rewrite.c>
       RewriteEngine On
       RewriteBase /phonebook/
       RewriteCond %{REQUEST_FILENAME} !-f
       RewriteCond %{REQUEST_FILENAME} !-d
       RewriteRule ^(.*)$ index.php/$1 [L]
     </IfModule>
     ```
   - In `application/config/config.php`:
     ```php
     $config['index_page'] = '';
     ```

---

## 🎲 Usage

- **Dashboard (Homepage):**  
  `http://localhost/phonebook/` — Summary tiles and latest 5 contacts.

- **Contacts List:**  
  `http://localhost/phonebook/contacts` — Search, filter, sort, bulk-delete.

- **Add Contact:**  
  `http://localhost/phonebook/contacts/create`

- **Edit Contact:**  
  Click a contact’s **Name** link or visit `http://localhost/phonebook/contacts/edit/{id}`

---

## 📂 File Structure

```
phonebook/
├─ application/
│  ├─ controllers/
│  │  ├─ Dashboard.php
│  │  └─ Contacts.php
│  ├─ models/Contact_model.php
│  ├─ views/
│  │  ├─ templates/{header.php, footer.php}
│  │  ├─ dashboard/index.php
│  │  └─ contacts/{index.php, form.php}
│  └─ config/{config.php, database.php, autoload.php, routes.php}
├─ assets/css/style.css
├─ seed_contacts.sql
└─ index.php
```

---

## 🤝 Contributing

Contributions are welcome! Feel free to open issues or submit pull requests.

---

## 📄 License

This project is released under the MIT License. See [LICENSE](LICENSE) for details.

