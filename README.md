# Venue Management System

A web-based application for managing venue reservations, including features for both users (students/staff) and administrators.

## Features
-   **User Module**: Sign up, Login, View Venues, Make Reservations, Check Status.
-   **Admin Module**: Manage Venues, Approve/Reject Reservations, View Reports.

---

## 🚀 Quick Start (Local Development)

### Prerequisites
-   **XAMPP** (or any AMP stack) with PHP 8.2+ and MySQL.

### Installation Steps
1.  **Clone/Download** this repository into your `htdocs` folder (e.g., `C:\xampp\htdocs\Venue-Management-System`).
2.  **Start Services**: Open XAMPP Control Panel and start **Apache** and **MySQL**.
3.  **Setup Database**:
    -   Go to `http://localhost/phpmyadmin`.
    -   Create a database named `venue_management`.
    -   Import the `venue_management.sql` file provided in this project.
4.  **Configure Credentials**:
    -   By default, it works with `root` (no password) on `localhost`.
    -   If you have a custom setup, copy `.env.example` to `.env` and update your credentials:
        ```ini
        DB_HOST=localhost
        DB_USER=root
        DB_PASSWORD=yourpassword
        DB_NAME=venue_management
        ```
5.  **Run**: Visit `http://localhost/Venue-Management-System/Venue-Management-System/main.php`.

---

## ☁️ Deployment (Cloud)

This project is configured to run on **Render** (Web) with an external database (TiDB/Aiven).

### 1. Database Setup
Since Render does not provide a free MySQL database, you must host it externally (e.g., **TiDB Cloud** or **Aiven**).
-   Create a free MySQL cluster.
-   Connect to it using a desktop client (HeidiSQL/DBeaver).
-   Run the `venue_management.sql` script to create the tables.

### 2. Connect to Render
1.  Push your code to **GitHub**.
2.  Create a new **Web Service** on Render.
3.  Choose **Docker** as the runtime.
4.  Add the following **Environment Variables** (or upload your `.env` file as a "Secret File"):
    -   `DB_HOST`: (your cloud database host)
    -   `DB_PORT`: `4000` (or 3306)
    -   `DB_USER`: (your cloud user)
    -   `DB_PASSWORD`: (your cloud password)
    -   `DB_NAME`: (your cloud db name)

*For a detailed walkthrough, read `RENDER_GUIDE.md` included in this repo.*

---

## Default Login Credentials

**Admins:**
-   **Email**: `chiachintat10@gmail.com`
-   **Password**: `12341234`

**Users (Students):**
-   **Email**: `1211100564@student.mmu.edu.my`
-   **Password**: `iampretty`
