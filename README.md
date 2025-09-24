# Insolvency Data System

A Laravel-based authentication system built from scratch without using authentication plugins. Features custom authentication with Tailwind CSS for modern styling.

## Features

- **Custom Authentication System**: Built without Laravel Breeze/Jetstream
- **User Management**: Registration, login, logout functionality
- **Role-based Access**: Admin and User roles
- **Modern UI**: Tailwind CSS styling with responsive design
- **Security**: CSRF protection, password hashing, session management
- **Middleware**: Custom authentication and admin middleware

## Installation

1. **Clone or download the project**
   ```bash
   cd "insolvensy data system"
   ```

2. **Install PHP dependencies**
   ```bash
   composer install
   ```

3. **Install Node.js dependencies**
   ```bash
   npm install
   ```

4. **Environment Setup**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

5. **Database Configuration**
   - Update your `.env` file with database credentials:
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=insolvency_system
   DB_USERNAME=your_username
   DB_PASSWORD=your_password
   ```

6. **Run Database Migrations**
   ```bash
   php artisan migrate
   ```

7. **Seed the Database**
   ```bash
   php artisan db:seed
   ```

8. **Build Assets**
   ```bash
   npm run build
   ```

9. **Start the Development Server**
   ```bash
   php artisan serve
   ```

## Default Users

The seeder creates the following default users:

- **Admin User**
  - Email: `admin@example.com`
  - Password: `password123`
  - Role: Admin

- **Regular User**
  - Email: `user@example.com`
  - Password: `password123`
  - Role: User

## Project Structure

```
app/
├── Http/
│   ├── Controllers/
│   │   └── Auth/
│   │       └── AuthController.php      # Authentication logic
│   ├── Middleware/
│   │   ├── Authenticate.php            # Custom auth middleware
│   │   ├── AdminMiddleware.php         # Admin access control
│   │   └── RedirectIfAuthenticated.php # Guest redirect
│   └── Kernel.php                      # Middleware registration
├── Models/
│   └── User.php                         # User model with auth methods
└── Services/
    └── AuthService.php                  # Authentication service layer

resources/
├── css/
│   └── app.css                          # Tailwind CSS with custom components
├── js/
│   ├── app.js                           # Main JS file
│   └── bootstrap.js                     # Axios configuration
└── views/
    ├── layouts/
    │   └── app.blade.php                # Main layout with navigation
    ├── auth/
    │   ├── login.blade.php              # Login form
    │   └── register.blade.php           # Registration form
    └── dashboard.blade.php             # User dashboard

routes/
└── web.php                              # Application routes

database/
├── migrations/
│   └── create_users_table.php           # Users table migration
└── seeders/
    ├── DatabaseSeeder.php               # Main seeder
    └── UserSeeder.php                    # User data seeder
```

## Authentication Flow

1. **Registration**: Users can register with name, email, password, and role
2. **Login**: Email/password authentication with remember me option
3. **Session Management**: Secure session handling with CSRF protection
4. **Authorization**: Role-based access control (Admin/User)
5. **Logout**: Secure session termination

## Customization

### Adding New Roles
1. Update the `role` enum in the users migration
2. Add role checks in the User model
3. Create new middleware for role-specific access

### Styling
- Modify `resources/css/app.css` for custom Tailwind components
- Update `tailwind.config.js` for theme customization
- Customize views in `resources/views/`

### Authentication Logic
- Modify `AuthService.php` for custom authentication logic
- Update `AuthController.php` for controller behavior
- Extend middleware for additional security features

## Security Features

- Password hashing using Laravel's Hash facade
- CSRF token protection
- Session security with regeneration
- Account activation/deactivation
- Role-based authorization
- Input validation and sanitization

## Development

For development with hot reloading:
```bash
npm run dev
```

This will watch for changes and automatically rebuild assets.

## License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
