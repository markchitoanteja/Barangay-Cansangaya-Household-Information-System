# Barangay Cansangaya Household Information System

A lightweight **PHP MVC web application** developed as part of a
capstone project titled:

**"Innovative Web Application Development for Barangay Cansangaya
Household Information System."**

The system helps barangay staff manage **household records, residents,
and administrative data** through a centralized web interface.

------------------------------------------------------------------------

## 📸 Screenshot

![Login Page](docs/screenshot.png)

------------------------------------------------------------------------

## ✨ Features

-   Secure **Admin / Staff authentication**
-   Household information management
-   Resident records
-   Certificate and documentation support
-   Flash messaging system
-   Lightweight custom **MVC architecture**
-   Environment configuration using `.env`
-   Modular **helper system**
-   Session-based authentication

------------------------------------------------------------------------

## 🧱 Project Architecture

    app
    │
    ├─ core
    │   ├─ Controller.php
    │   ├─ Database.php
    │   └─ Env.php
    │
    ├─ controllers
    │   ├─ HomeController.php
    │   ├─ LoginController.php
    │   └─ DashboardController.php
    │
    ├─ models
    │   └─ User.php
    │
    ├─ views
    │   ├─ auth
    │   │   └─ login.php
    │   └─ home
    │       └─ index.php
    │
    ├─ helpers
    │   ├─ env_helper.php
    │   ├─ request_helper.php
    │   ├─ response_helper.php
    │   ├─ session_helper.php
    │   ├─ url_helper.php
    │   └─ debug_helper.php
    │
    ├─ bootstrap
    │   └─ autoload.php
    │
    docs
    └─ screenshot.png

    public
    └─ assets

------------------------------------------------------------------------

## ⚙️ Requirements

-   PHP **8.0+**
-   MySQL / MariaDB
-   Apache / Nginx

------------------------------------------------------------------------

## 🚀 Installation

1.  **Clone the repository**

``` bash
git clone https://github.com/yourusername/barangay-household-system.git
```

2.  **Navigate to the project**

``` bash
cd barangay-household-system
```

3.  **Create `.env` file**

Example configuration:

    APP_NAME=Barangay Cansangaya Household Information System
    APP_VERSION=1.0.0

    DB_HOST=127.0.0.1
    DB_USER=root
    DB_PASS=
    DB_NAME=cansangaya_db
    DB_CHARSET=utf8mb4

4.  **Start your local server**

``` bash
php -S localhost:8000
```

Open:

    http://localhost:8000

------------------------------------------------------------------------

## 🔐 Authentication Flow

    HomeController
          │
          ├─ if logged in → DashboardController
          │
          └─ if not logged in → LoginController
                                     │
                                     ▼
                                  Login View

Session helpers:

``` php
session_set('is_login', true);
session_get('is_login');
session_destroy_all();
```

------------------------------------------------------------------------

## 🎨 Frontend

-   **Bootstrap 5**
-   **Font Awesome**
-   **jQuery**
-   Custom CSS

------------------------------------------------------------------------

## 📚 Capstone Information

**Project Title**

> Innovative Web Application Development for Barangay Cansangaya
> Household Information System

Purpose:\
To digitize barangay household data and improve administrative
efficiency through a centralized web-based system.

------------------------------------------------------------------------

## 👨‍💻 Developer

Developed for an **Information Technology Capstone Project**.
