# MAVI-PROJECT-RESTAURANT
PROJECT RESTAURANT WITH SYMFONY
# Symfony Project

## Overview
This Symfony-based project is designed to manage reservations, user authentication, and order processing for a restaurant system. It utilizes a clean and modular architecture with Symfony's powerful components and adheres to best practices for web application development.

## Features
### Admin Module
- View and manage all reservations.
- Track total reservations via a dashboard.

### User Authentication (Login Module)
- User registration with roles (e.g., customer, admin).
- Login functionality to authenticate users.

### Order Management
- Submit and process meal orders via a form.
- Save order details to the database for future reference.

### Restaurant Module
- Display available reservations to users.
- Render interactive pages using Twig templates.

## Technologies Used
- **PHP**: Core programming language.
- **Symfony Framework**: Handles routing, controllers, and ORM.
- **Doctrine ORM**: Manages database interactions.
- **Twig**: Templating engine for rendering dynamic views.
- **HTML/CSS/JavaScript**: For front-end interfaces.

## Requirements
To run this project, ensure the following are installed:

- PHP 8.0 or higher
- Composer
- Symfony CLI
- MySQL or another supported database
- A web server (e.g., Apache or Nginx)

## Installation
1. Clone the repository:
   ```bash
   git clone https://github.com/User-lang-max/MAVI-PROJECT-RESTAURANT.git
   ```

2. Navigate to the project directory:
   ```bash
   cd MAVI-PROJECT-RESTAURANT
   ```

3. Install dependencies using Composer:
   ```bash
   composer install
   ```

4. Set up environment variables:
   - Copy `.env` to `.env.local` and configure your database credentials:
     ```env
     DATABASE_URL="mysql://username:password@127.0.0.1:3306/reser"
     ```

5. Run database migrations:
   ```bash
   php bin/console doctrine:migrations:migrate
   ```

6. Start the Symfony local server:
   ```bash
   symfony server:start
   ```

7. Access the application:
   - Open your browser and go to `http://127.0.0.1:8000`

## Usage
### Admin Dashboard
- Visit `/admin` to manage reservations and view analytics.

### User Authentication
- Visit `/login` to register or log in.

### Order Submission
- Submit orders via `/order_form` using a form with required details like name, email, and meal type.

### Restaurant Reservations
- Visit `/restau` to view reservation options.
