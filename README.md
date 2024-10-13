Project Overview

The Reminder API is built using PHP 8.2 and Laravel 11.9, offering a robust backend for managing events and email reminders. 
The project utilizes JWT for secure authentication, provides bulk data import with FastExcel, and integrates IndexDB for offline database support. 
The API also supports scheduling email notifications for events through jobs and artisan commands.

Technologies:

PHP: 8.2
    Laravel: 11.9
    Laravel UI: 4.5 (for authentication scaffolding)
    JWT Authentication: tymon/jwt-auth 2.1 (for token-based authentication)
    FastExcel: rap2hpoutre/fast-excel 5.5 (for bulk data import)
    MySQL: Database used for primary storage
    IndexDB: Offline storage mechanism for local database management


Project Features
    Event Management (CRUD): Create, update, delete, and view events with specific details.
    Email Management (CRUD): Manage email notifications and configurations.
    Mail Scheduling: Using ReminderMail for Laravel Mail, EmailJob for job scheduling, and ReminderEmails artisan command to trigger emails at specific event times.



Installation
Prerequisites
Ensure you have the following installed:

    PHP 8.2+
    Composer
    MySQL
    Node.js (for frontend assets)
    Git (optional)

Steps to Install and Run the Project
    
    # Clone the repository
        1. git clone https://github.com/wasim47/event-reminders
        cd event-reminders
    
    # Install Node dependencies (if you're using frontend assets)

        2. composer install
        3. npm install

    # Set up environment variables

        Duplicate the .env.example file and rename it to .env. Update database and mail configuration:

    # Generate the application key

        php artisan key:generate
    
    # Configure the JWT Secret

        php artisan jwt:secret

    # Set up the database

        Update .env with your MySQL database credentials:

            DB_CONNECTION=mysql
            DB_HOST=127.0.0.1
            DB_PORT=3306
            DB_DATABASE=your_database_name
            DB_USERNAME=your_database_username
            DB_PASSWORD=your_database_password
        
        # Run migrations then run project

            Run migrations

            php artisan serve