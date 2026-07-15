# Product CRUD Application (PHP & Vanilla JS)

A full-stack CRUD (Create, Read, Update, Delete) application for managing products. This project demonstrates a decoupled architecture with a RESTful backend API built in vanilla PHP and a responsive frontend built with vanilla JavaScript, Axios, and Bootstrap. The entire environment is fully dockerized for easy setup and deployment.

## 🚀 Features

* **RESTful API:** Built with vanilla PHP 8.2, handling `GET`, `POST`, `PUT`, `PATCH`, and `DELETE` requests.
* **Database Integration:** Secure database interactions using PHP Data Objects (PDO) with MySQL.
* **API Documentation:** Interactive Swagger UI documentation available out-of-the-box (OpenAPI 3.0).
* **Modern Frontend:** Vanilla JavaScript using ES6 Modules, interacting with the backend via **Axios**.
* **Responsive UI:** Styled with Bootstrap 5 and custom CSS.
* **Dockerized:** Independent Docker Compose setups for both the Frontend (Nginx) and Backend (PHP/Apache/MySQL) environments.

## 🛠️ Technologies Used

### Backend (`crud-api`)
* PHP 8.2
* MySQL 8.0
* OpenAPI / Swagger UI
* Docker & Docker Compose

### Frontend (`crud-frontend-axios`)
* HTML5, CSS3, JavaScript (ES6 Modules)
* Axios (HTTP client)
* Bootstrap 5
* Nginx (Docker Alpine image)

## 📁 Project Structure

```text
.
├── crud-api/                  # Backend REST API
│   ├── data/                  # MySQL initialization scripts (db.sql)
│   ├── src/                   # PHP source code, config, and views
│   ├── compose.yaml           # Docker compose for PHP and MySQL
│   └── Dockerfile             # PHP environment setup
│
└── crud-frontend-axios/       # Frontend Application
    ├── src/                   # HTML, CSS, and JS modules
    │   ├── scripts/           # Modularized JS (API calls, DOM manipulation)
    │   └── styles/            # CSS stylesheets
    ├── compose.yaml           # Docker compose for Nginx
    └── Dockerfile             # Nginx environment setup
