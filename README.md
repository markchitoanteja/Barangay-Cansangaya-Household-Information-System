# Barangay Household Information System (BCHIS)

### Barangay Cansangaya -- Can-Avid, Eastern Samar

The **Barangay Cansangaya Household Information System (BCHIS)** is a
**web-based information management system** developed to help barangay
officials efficiently manage household and resident records.

The system centralizes community data, making it easier to maintain
accurate records, monitor households, and generate reports needed for
barangay operations.

BCHIS runs locally using **Apache, PHP, and MySQL** through **XAMPP**.

------------------------------------------------------------------------

# System Overview

This application helps barangay officials:

-   Manage household records
-   Maintain resident information
-   Organize barangay demographic data
-   Search and filter residents easily
-   Access statistics through a dashboard

The system provides a user-friendly interface designed for local
government administrative work.

------------------------------------------------------------------------

# System Features

-   Household Information Management
-   Resident Records Management
-   Dashboard with Barangay Statistics
-   Record Search and Filtering
-   Secure Login System
-   Organized Local Database Storage

------------------------------------------------------------------------

# System Requirements

Before installing BCHIS, ensure your computer meets the following
requirements.

## Operating System

-   Windows 10
-   Windows 11

## Hardware

-   Minimum **4 GB RAM**
-   At least **2 GB free disk space**

## Required Software

  ---------------------------------------------------------------------------------
  Software           Description                    Download
  ------------------ ------------------------------ -------------------------------
  XAMPP              Apache, PHP, and MySQL server  https://www.apachefriends.org
                     package                        

  Google Chrome      Recommended web browser        https://www.google.com/chrome
  ---------------------------------------------------------------------------------

------------------------------------------------------------------------

# Installing Required Software

## Install XAMPP

1.  Download XAMPP from: https://www.apachefriends.org

2.  Run the installer.

3.  Install XAMPP in the default directory:

```
    C:\xampp

4.  Open **XAMPP Control Panel**.

5.  Start the following services:

-   Apache
-   MySQL

------------------------------------------------------------------------

# System Installation

## Step 1 --- Locate the System Folder

Open the project folder:

    Barangay-Cansangaya-Household-Information-System

------------------------------------------------------------------------

## Step 2 --- Run the Installer

Open the **setup** folder and double-click:

    Setup.exe

Follow the instructions shown in the installer.

The installer will install the **BHIS Launcher** on your computer.

------------------------------------------------------------------------

# Database Setup

Before using the system, the database must be imported.

## Step 1 --- Open phpMyAdmin

Open your browser and go to:

    http://localhost/phpmyadmin

------------------------------------------------------------------------

## Step 2 --- Create the Database

1.  Click **New**
2.  Create a database named:

```
    bchis

3.  Set the collation to:

```
    utf8mb4_general_ci

------------------------------------------------------------------------

## Step 3 --- Import the Database Schema

1.  Select the **bchis** database
2.  Click the **Import** tab
3.  Click **Choose File**
4.  Select the file located at:

```
    app/data/database_schema.sql

5.  Click **Go**

The system database will now be installed.

------------------------------------------------------------------------

# Environment Configuration

The application uses the following environment configuration:

    DB_HOST=127.0.0.1
    DB_NAME=bchis
    DB_USER=root
    DB_PASS=
    DB_CHARSET=utf8mb4

    APP_NAME=Barangay Cansangaya Household Information System
    APP_ENV=local
    APP_DEBUG=true
    APP_VERSION=1.2.5

------------------------------------------------------------------------

# Starting the System

After installation:

1.  Go to your **Desktop**
2.  Double-click:

```
    Barangay Household Information System

The launcher will automatically:

-   Start Apache
-   Start MySQL
-   Open the system in your browser

------------------------------------------------------------------------

# Opening the System Manually

You can also access the system manually through your browser:

    http://localhost/Barangay-Cansangaya-Household-Information-System

------------------------------------------------------------------------

# How to Use the System

## Login

Open the system and enter your assigned **username** and **password**.

Only authorized users can access the system.

------------------------------------------------------------------------

## Dashboard

After logging in, the dashboard displays:

-   Barangay statistics
-   Household data overview
-   Navigation to system modules

The dashboard serves as the main control panel of the application.

------------------------------------------------------------------------

## Managing Household Records

Users can:

-   Add new households
-   Edit existing records
-   Search residents
-   View household information
-   Maintain barangay demographic records

All records are stored securely in the system database.

------------------------------------------------------------------------

# System Screenshots

## Startup Launcher

![Startup Screen](docs/startup.png)

The launcher prepares the system and starts required services.

------------------------------------------------------------------------

## Login Screen

![Login Screen](docs/login.png)

Users must log in to access the system.

------------------------------------------------------------------------

## Dashboard

![Dashboard](docs/dashboard.png)

The dashboard provides access to system functions and barangay data.

------------------------------------------------------------------------

# Important Notes

-   Do **not rename** the system folder.
-   Do **not move** the system folder after installation.
-   XAMPP must remain installed in:

    C:\xampp

Changing these settings may cause the system to stop working.

------------------------------------------------------------------------

# Troubleshooting

If the system does not open:

1.  Ensure \*\*XAMPP is installed in C:`\xampp*`{=tex}\*
2.  Make sure **Apache and MySQL are running**
3.  Restart the **BHIS Launcher**
4.  Confirm the **bchis database was imported successfully**

------------------------------------------------------------------------

# Technical Support

If you encounter issues with the system, contact the system developer or
barangay IT administrator.

------------------------------------------------------------------------

# License

© 2026\
**Barangay Cansangaya Household Information System (BCHIS)**\
All Rights Reserved.
