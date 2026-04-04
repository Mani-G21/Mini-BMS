# Mini-BMS (Movie Booking Management System)

A modern, RESTful API for managing movie bookings, theaters, shows, and cities. Built with Laravel 12 and designed with clean architecture principles.

## 📋 Overview

Mini-BMS is a comprehensive movie booking management system that provides APIs for managing movies, theaters, shows, and user authentication. The system supports both public and admin functionalities with JWT-based authentication.

## ✨ Features

- **Movie Management**
  - Browse movies by status (now showing, coming soon)
  - Filter movies by city, language, genre
  - View movie details including trailers, ratings, and descriptions
  - Admin can create and update movies

- **Theater Management**
  - View theaters by city
  - Admin can manage theater information
  - Support for multiple screens and locations

- **Show Management**
  - Browse available shows for movies
  - Filter by date, time, language, and format
  - Support for different price tiers
  - Admin can schedule and manage shows

- **City Management**
  - View available cities
  - Filter movies and theaters by city

- **Authentication & Authorization**
  - OTP-based authentication via email
  - JWT token-based API access
  - Role-based access control (User/Admin)
  - Token refresh mechanism

## 🛠️ Technology Stack

- **Backend Framework**: Laravel 12
- **PHP Version**: 8.2+
- **Database**: PostgreSQL (configurable)
- **Cache & Queue**: Redis
- **Authentication**: JWT (tymon/jwt-auth)
- **Frontend Build**: Vite + Tailwind CSS
- **Testing**: PHPUnit

## 📦 Installation

### Prerequisites

- PHP 8.2 or higher
- Composer
- PostgreSQL
- Redis
- Node.js & npm

### Setup Steps

1. **Clone the repository**
   ```bash
   git clone https://github.com/Mani-G21/Mini-BMS.git
   cd Mini-BMS
   ```

2. **Install PHP dependencies**
   ```bash
   composer install
   ```

3. **Install JavaScript dependencies**
   ```bash
   npm install
   ```

4. **Environment Configuration**
   ```bash
   cp .env.example .env
   ```
   
   Update the following environment variables:
   - `DB_DATABASE`: Your PostgreSQL database name
   - `DB_USERNAME`: Your database username
   - `DB_PASSWORD`: Your database password
   - `JWT_SECRET`: Your JWT secret key
   - `REDIS_HOST`: Your Redis host (default: 127.0.0.1)
   - `MAIL_*`: Email configuration for OTP delivery

5. **Generate Application Key**
   ```bash
   php artisan key:generate
   ```

6. **Run Migrations**
   ```bash
   php artisan migrate
   ```

7. **Start the Development Server**
   ```bash
   composer run dev
   ```
   
   This will concurrently run:
   - Laravel development server (http://localhost:8000)
   - Queue worker
   - Log viewer (Pail)
   - Vite dev server

## 🔌 API Endpoints

### Public Endpoints

#### Authentication
- `POST /api/v1/auth/otp/get` - Request OTP
- `POST /api/v1/auth/otp/verify` - Verify OTP and get JWT token
- `POST /api/v1/auth/refresh` - Refresh JWT token

#### Movies
- `GET /api/v1/movies` - List all movies (with filters)
- `GET /api/v1/movies/{id}` - Get movie details

#### Cities
- `GET /api/v1/cities` - List all cities
- `GET /api/v1/cities/{id}` - Get city details

### Authenticated Endpoints

#### User Profile
- `GET /api/v1/me` - Get authenticated user details

#### Theaters
- `GET /api/v1/theaters` - List all theaters
- `GET /api/v1/theaters/{id}` - Get theater details

#### Shows
- `GET /api/v1/shows` - List all shows (with filters)
- `GET /api/v1/shows/{id}` - Get show details

### Admin Endpoints

#### Movies Management
- `POST /api/v1/admin/movies` - Create new movie
- `PUT /api/v1/admin/movies/{id}` - Update movie

#### Theaters Management
- `POST /api/v1/admin/theaters` - Create theater
- `PUT /api/v1/admin/theaters/{id}` - Update theater
- `DELETE /api/v1/admin/theaters/{id}` - Delete theater

#### Shows Management
- `POST /api/v1/admin/shows` - Create show
- `PUT /api/v1/admin/shows/{id}` - Update show
- `DELETE /api/v1/admin/shows/{id}` - Delete show

## 🗄️ Database Schema

### Core Tables
- **users** - User accounts with role-based access
- **movies** - Movie information (title, description, duration, genre, etc.)
- **cities** - Available cities
- **movie_city** - Movie-city relationship (pivot table)
- **theaters** - Theater information
- **shows** - Show schedules with pricing tiers

## 🧪 Testing

Run the test suite:
```bash
composer run test
```

Or directly with PHPUnit:
```bash
php artisan test
```

## 🚀 Development

### Code Quality
The project uses Laravel Pint for code formatting:
```bash
./vendor/bin/pint
```

### Building Assets
Build frontend assets for production:
```bash
npm run build
```

## 📝 Architecture

The project follows clean architecture principles with:
- **DTOs (Data Transfer Objects)** - For data transformation
- **Services** - Business logic layer
- **Repositories** - Data access layer
- **Controllers** - HTTP request handling
- **Validators** - Request validation
- **Middleware** - Authentication and authorization

## 🔐 Security

- JWT-based authentication
- Role-based access control
- OTP verification for user authentication
- Environment-based configuration
- CSRF protection

## 📄 License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

## 🤝 Contributing

Contributions are welcome! Please feel free to submit a Pull Request.

## 📧 Contact

For any questions or issues, please open an issue on GitHub.
