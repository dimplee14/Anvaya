👗 Anvaya — Personalized Fashion & Design Platform

<p align="center">
  <strong>Your Style. Your Choice. Your Identity.</strong>
  <br />
  A web platform for personalized fashion preferences and designer-managed orders.
</p><p align="center">
  <img src="https://img.shields.io/badge/PHP-Backend-777BB4?style=for-the-badge&logo=php&logoColor=white" alt="PHP" />
  <img src="https://img.shields.io/badge/MySQL-Database-4479A1?style=for-the-badge&logo=mysql&logoColor=white" alt="MySQL" />
  <img src="https://img.shields.io/badge/Platform-Web%20Application-0A7EA4?style=for-the-badge" alt="Web Application" />
</p>---

🌟 Overview

Anvaya is a fashion-focused web application designed to bring personalized style preferences and fashion order management together.

The project includes a database structure for managing customer information, design preferences, designers, orders, order-status history, reviews, and administrative records.

Anvaya aims to make the process of organizing fashion preferences and managing designer-related orders more convenient through a centralized platform.

✨ Key Modules

👤 Customer Management

- Customer account information
- Personalized fashion design preferences
- Style, occasion, colour, and budget preferences
- Support for uploaded photos

🎨 Designer Management

- Designer information and contact details
- Designer records and order assignments
- Support for designer-related workflows

📦 Order Management

- Customer order records
- Order descriptions and measurements
- Order pricing and delivery-date records
- Order-status tracking and status history

⭐ Reviews & Feedback

- Customer ratings and written reviews
- Review records associated with the platform
- Support for review photos

🛠️ Administration & Contact Management

- Administrator records
- Customer contact requests
- Contact request status tracking

«Note: These modules reflect the database structure. The availability of each feature in the working interface should be verified against the application code.»

---

🧰 Technology Stack

Technology| Purpose
PHP| Server-side application logic
MySQL| Relational database
SQL| Database schema and queries
HTML, CSS, JavaScript| Web interface technologies, where used

🗄️ Database Structure

The repository includes SQL files for database setup and schema definition.

The database contains tables such as:

- "users"
- "user_design_preferences"
- "designers"
- "orders"
- "order_status_history"
- "contact_requests"
- "admins"
- "reviews"

These tables represent the main entities involved in customer preferences, order management, reviews, and administration.

📁 Project Structure

Anvaya/
├── admin/
├── user/
├── uploads/
│   └── review_photos/
├── index.php
├── anvaya.sql
├── anvaya_schema.sql
└── README.md

This is a simplified overview. Additional files and folders may exist in the repository.

🚀 Getting Started

Prerequisites

Before running Anvaya locally, make sure you have:

- PHP
- MySQL
- A local PHP development environment, such as XAMPP
- A modern web browser
- Git (optional, for cloning the repository)

Installation

1. Clone the repository

git clone https://github.com/dimplee14/Anvaya.git

2. Open the project directory

cd Anvaya

3. Configure the database

- Start Apache and MySQL in your local development environment.
- Create a MySQL database for Anvaya.
- Import the appropriate SQL file from the repository.
- Configure the database connection using the project's existing configuration.

4. Run the application

Place the project in your local server's web directory and open its local URL in your browser.

For XAMPP, the URL may look like:

http://localhost/Anvaya/

Adjust the URL if your project uses a different directory or configuration.

---

🔐 Security Considerations

- Keep database credentials out of public source code.
- Validate and sanitize user input on the server.
- Apply appropriate authentication and authorization checks.
- Validate uploaded files and restrict permitted file types.
- Avoid exposing sensitive customer information.

🔮 Future Enhancements

Potential improvements for Anvaya include:

- AI-assisted fashion recommendations
- Personalized designer discovery
- Order-status notifications
- Secure online payment integration
- Improved mobile responsiveness
- Enhanced reporting and analytics

These are potential future enhancements, not claims of existing functionality.

🤝 Contributing

Contributions, suggestions, and bug reports are welcome.

1. Fork the repository.
2. Create a feature branch.
3. Make and test your changes.
4. Submit a pull request describing your improvements.

📄 License

A license has not been specified in this README. Add a suitable license file before distributing the project under open-source terms.

---

<p align="center">
  <strong>Anvaya</strong>
  <br />
  Personalized Fashion. Thoughtful Design. Connected Experiences.
</p>
