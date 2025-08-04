# School App

## Table of Contents

- [Overview](#overview)
- [Features](#features)
- [Architecture](#architecture)
- [Technology Stack](#technology-stack)
- [Getting Started](#getting-started)
    - [Prerequisites](#prerequisites)
    - [Installation](#installation)
    - [Configuration](#configuration)
    - [Running the Application](#running-the-application)
- [Project Structure](#project-structure)
- [Testing](#testing)
- [Deployment & Production Practices](#deployment--production-practices)
- [Improvements & Recommendations](#improvements--recommendations)

---

## Overview

This app is a robust, highly modular school management platform built using Laravel and Livewire. It supports comprehensive administration for courses, sections, teachers, and students, leveraging modern PHP best practices, advanced authorization, and a clean, reactive user interface.

---

## Features

- **Role-Based Dashboards:** Dedicated views and functionalities for Admin, Teacher, and Student.
- **Course & Section Management:** Admins can create, update, and delete courses and sections. Teachers can manage grades for their sections.
- **User Authentication & Authorization:** Secure login, registration, password reset, and role-based access control.
- **Student Enrollment:** Students can enroll in available sections and view their grades.
- **Teacher Grading:** Teachers can enter, update, and save student grades for their sections.
- **Adaptive UI:** Responsive, modern frontend using Tailwind CSS and Flux UI components.
- **Queue & Job Management:** Asynchronous job processing with support for multiple queue drivers (database, Redis, SQS, more).
- **File Storage:** Configurable local and S3 storage for storing files and assets.
- **Caching:** Multiple cache backends (database, Redis, Memcached, etc.) with lock support.
- **Notifications:** Integration for email (SMTP, SES, Postmark, Resend) and Slack notifications.
- **Comprehensive Configuration:** Environment-based configuration for all services.

---

## Architecture

- **MVC Pattern:** Follows Laravel's Model-View-Controller paradigm for clean separation.
- **Livewire Components:** All dynamic UIs are powered by Livewire, reducing JavaScript complexity and enabling reactive interfaces.
- **Policy-based Authorization:** Fine-grained access via policies (e.g., SectionPolicy).
- **Middleware:** Custom and built-in middleware for authentication, role checking, and more.
- **Service Providers:** Register and boot application services and policies.
- **Database Structure:** Modular migrations for users, courses, sections, jobs, cache, and more. Uses Eloquent ORM with relationships (one-to-many, many-to-many).

---

## Technology Stack

- **Backend:** PHP 8.2+, Laravel 11+
- **Frontend:** Livewire, Blade, Tailwind CSS, Flux UI
- **Database:** MySQL/MariaDB/PostgreSQL/SQLite (configurable)
- **Queue:** Database, Redis, SQS, Beanstalkd, etc.
- **Cache:** Database, Redis, Memcached, DynamoDB, Octane
- **Filesystem:** Local, S3, (FTP, SFTP, etc. possible)
- **Mail:** SMTP, SES, Postmark, Resend, etc.
- **Testing:** PestPHP, PHPUnit
- **Tooling:** Vite, Composer, Artisan

---

## Getting Started

### Prerequisites

- PHP 8.2 or higher
- Composer
- Node.js (18+ recommended) and npm
- Supported Database (MySQL, PostgreSQL, MariaDB, or SQLite)
- Redis (optional, for queue/cache)
- [Optional] AWS/S3 credentials for file storage
- [Optional] Mail service credentials (SES, Postmark, SMTP, etc.)

### Installation

1. **Clone the repository:**
   ```bash
   git clone https://github.com/imaazkhalid/school-app.git
   cd school-app
   ```

2. **Install PHP dependencies:**
   ```bash
   composer install --no-dev
   
   #or if you plan to use database seeder
   composer install
   ```

3. **Install Node dependencies:**
   ```bash
   npm install
   #or
   pnpm install
   ```

4. **Copy and set up environment variables:**
   ```bash
   cp .env.example .env
   ```
    - Edit `.env` to configure your environment (see [Configuration](#configuration)).

5. **Generate application key:**
   ```bash
   php artisan key:generate
   ```

6. **Run database migrations:**
   ```bash
   php artisan migrate
   ```

7. **Seed the database (optional, for initial data):**
   ```bash
   php artisan db:seed
   ```

8. **Build frontend assets:**
   ```bash
   npm run build
   # For development:
   npm run dev
   ```

### Configuration

Environment variables in `.env` control all aspects of the application. Key sections include:

- **App Configuration:**
  ```
  APP_NAME=SchoolApp
  APP_ENV=local
  APP_KEY=base64:...
  APP_DEBUG=true
  APP_URL=http://localhost
  ```

- **Database:**
  ```
  DB_CONNECTION=mysql
  DB_HOST=127.0.0.1
  DB_PORT=3306
  DB_DATABASE=school_app
  DB_USERNAME=root
  DB_PASSWORD=
  ```

- **Cache & Queue:**
  ```
  CACHE_STORE=database
  QUEUE_CONNECTION=database
  REDIS_HOST=127.0.0.1
  REDIS_PASSWORD=null
  REDIS_PORT=6379
  ```

- **Filesystem:**
  ```
  FILESYSTEM_DISK=local
  AWS_ACCESS_KEY_ID=your-key
  AWS_SECRET_ACCESS_KEY=your-secret
  AWS_DEFAULT_REGION=us-east-1
  AWS_BUCKET=your-bucket
  ```

- **Mail:**
  ```
  MAIL_MAILER=smtp
  MAIL_HOST=smtp.mailtrap.io
  MAIL_PORT=2525
  MAIL_USERNAME=null
  MAIL_PASSWORD=null
  MAIL_ENCRYPTION=null
  MAIL_FROM_ADDRESS=noreply@schoolapp.com
  MAIL_FROM_NAME="${APP_NAME}"
  ```

- **Third Party Services (optional):**
    - Postmark, SES, Resend, Slack, etc.
    - See `config/services.php` for environment variables used.

### Running the Application

#### Local Development

- **Start the PHP server:**
  ```bash
  composer run dev
  ```

- **Access the app:**  
  Open `http://localhost:8000` in your browser.

#### Queues & Jobs

- **Start a queue worker:**
  ```bash
  php artisan queue:work
  ```
- Configure your queue connection in `.env` (`QUEUE_CONNECTION=database|redis|sqs|etc.`).

#### Scheduler

- **Run scheduled tasks:**
  ```
  php artisan schedule:work
  ```
    - Or set up a cron job:  
      `* * * * * php /path/to/artisan schedule:run >> /dev/null 2>&1`

#### Storage

- **Link public storage:**
  ```bash
  php artisan storage:link
  ```
    - Ensures files are accessible via `/storage` URL.

---

## Project Structure

```
school-app/
├── app/                   # Controllers, Models, Livewire components, Providers, Policies
├── bootstrap/             # Bootstrap files
├── config/                # Application configuration
├── database/              # Migrations, seeders, factories
├── public/                # Publicly accessible files
├── resources/             # Blade views, JS, CSS, language files
├── routes/                # Web and console routes
├── storage/               # Logs, cache, compiled templates, file uploads
├── tests/                 # Unit and feature tests
├── vite.config.js         # Vite configuration
└── .env.example           # Example environment configuration
```

- **Livewire Components:**
    - `app/Livewire/Admin/` (Admin dashboards & CRUD)
    - `app/Livewire/Teacher/` (Teacher dashboards, grade mgmt)
    - `app/Livewire/Student/` (Student dashboards)
- **Models:**
    - `User`, `Teacher`, `Student`, `Course`, `Section`, etc.
- **Policies:**
    - Fine-grained access control (e.g., SectionPolicy)
- **Migrations:**
    - Table creation for users, courses, sections, jobs, cache, etc.
- **Seeders & Factories:**
    - Initial data for testing & development

---

## Testing

- **Run all tests:**
  ```bash
  ./vendor/bin/pest
  # Or
  php artisan test
  ```

- Tests are located in `tests/Unit` and `tests/Feature`.
- Pest is used for concise and expressive test syntax.

---

## Deployment & Production Practices

### Production Considerations

- **Environment Variables:**
    - Never commit `.env` to version control. Use proper secrets management.
- **Caching:**
    - Run `php artisan config:cache`, `route:cache`, and `view:cache` for performance.
- **Queue Workers:**
    - Always use a supervisor (e.g., SupervisorD, systemd) to keep queue workers running.
- **Scheduler:**
    - Set up a server cron for the Laravel scheduler.
- **Storage:**
    - Use S3 or another cloud provider for file storage.
- **Database:**
    - Use a production-grade database with backups and monitoring.
- **Logging:**
    - Forward logs to a centralized system (e.g., Papertrail, Stackdriver, ELK).
- **SSL:**
    - Always serve production traffic over HTTPS.
- **Vulnerability Scanning:**
    - Regularly run `composer audit` and update dependencies.
- **Zero Downtime Deployment:**
    - Use deployment tools like Envoyer, GitHub Actions, or Deployer.

---

## Improvements & Recommendations

- **Comprehensive API:**
    - Build a RESTful API for all resources to allow external integrations.
- **Advanced User Management:**
    - Add invitation, approval workflows, and granular permissions.
- **Bulk Import/Export:**
    - CSV/Excel import/export for students, courses, grades.
- **Notifications & Subscriptions:**
    - In-app notifications, email digests, push notifications.
- **Audit Logging:**
    - Record all changes and critical actions for accountability.
- **Two-Factor Authentication:**
    - Add 2FA for enhanced security.
- **Dark & Light Themes:**
    - Extend UI customization for greater accessibility and branding.
- **Accessibility:**
    - Ensure WCAG 2.1 compliance for all UI components.
- **Internationalization:**
    - Add more languages and locale support.
- **Containerization:**
    - Provide Docker & Docker Compose setup for reproducible deployments.
- **CI/CD Pipeline:**
    - Integrate automated testing, linting, security checks, and deployments.
- **Monitoring:**
    - Integrate application performance monitoring (APM) and uptime checks.
- **Rate Limiting, Throttling, and Spam Protection:**
    - Defend against abuse and ensure system stability.
