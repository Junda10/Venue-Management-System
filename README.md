# 🎓 University Venue Management System

A comprehensive web application designed to streamline the reservation and management of university venues. The system provides a seamless interface for students to book facilities and for administrators to manage requests efficiently.

## 🌐 Live Website
The application is live and can be accessed at:
**[https://venue-management-system.onrender.com/](https://venue-management-system.onrender.com/)**

---

## 🛠 Built With
- **Frontend**: HTML5, CSS3 (Vanilla), JavaScript
- **Backend**: PHP 8.2+
- **Database**: MySQL / TiDB Cloud (Serverless)
- **Deployment**: Docker, Render

---

## ✨ Core Features

### 👤 Student/User Module
- **Account Management**: Secure registration and login.
- **Venue Exploration**: View available venues with descriptions and capacity.
- **Smart Booking**: Check real-time availability and request time slots.
- **Reservation Tracking**: View upcoming and past reservations.
- **Reporting**: Report issues or provide feedback on specific venues.

### 🛡 Admin Module
- **Dashboard**: Overview of system statistics and pending requests.
- **Venue Management**: Add, update, or delete venues and their details.
- **Application Review**: Process reservation requests (Approve/Reject).
- **User Management**: View and manage student and administrator profiles.
- **System Diagnostics**: Built-in tools for database connection monitoring.

---

## 🚀 Getting Started

### 💻 Local Deployment (XAMPP)
1. **Clone the Repository**:
   Place the project folder in your `htdocs` directory.
2. **Start Services**:
   Open XAMPP and start **Apache** and **MySQL**.
3. **Database Setup**:
   - Access `phpMyAdmin`.
   - Create a database: `venue_management`.
   - Import `venue_management.sql`.
4. **Configuration**:
   Update `db_connect.php` with your local credentials if different from defaults (`root` / no password).
5. **Launch**:
   Navigate to `http://localhost/Venue-Management-System/main.php`.

### ☁️ Cloud Deployment (Render + TiDB)
This project is pre-configured for Docker-based deployment on Render.

1. **Database**: 
   - Set up a free cluster on **TiDB Cloud**.
   - Import `venue_management.sql`.
2. **Environment Variables**:
   Set the following in the Render Dashboard:
   - `DB_HOST`: Your TiDB Host
   - `DB_PORT`: `4000`
   - `DB_USER`: Your TiDB User
   - `DB_PASSWORD`: Your TiDB Password
   - `DB_NAME`: Your database name
3. **SSL Requirement**:
   The system is configured to automatically use **SSL (TLS)** when connecting to TiDB Cloud to ensure "secure transport" compliance.

---

## 🔐 Test Credentials

| Role | UserID | Password |
| :--- | :--- | :--- |
| **Admin** | `A001` | `12341234` |
| **Student** | `1211101262` | `12345678` |

---

## 🔧 Technical Notes
- **Connection Security**: The `db_connect.php` uses `mysqli_ssl_set` for mandatory SSL connections required by modern cloud databases.
- **Header Management**: PHP logic is placed at the top of files to ensure correct session initialization and redirects without "headers already sent" errors.
