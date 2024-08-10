# United Tractors Test

This project is a test application developed as part of the United Tractors assessment. It demonstrates the use of [Laravel](https://laravel.com/) for building a web application with a simple and intuitive structure.

## Features

- **User Authentication**: Basic login and registration functionality.
- **CRUD Operations**: Create, read, update, and delete features for managing data.
- **Database Integration**: MySQL is used for database management.

## Getting Started

### Prerequisites

- PHP >= 7.3
- Composer
- MySQL

### Installation

1. Clone the repository:
   ```bash
   git clone https://github.com/KhairilAmin/United_Tractors_Test.git
   ```
2. Navigate to the project directory:
   ```bash
   cd United_Tractors_Test
   ```
3. Install dependencies:
   ```bash
   composer install
   ```
4. Create a `.env` file by copying the example file:
   ```bash
   cp .env.example .env
   ```
5. Generate an application key:
   ```bash
   php artisan key:generate
   ```
6. Configure your `.env` file with your database credentials.

7. Run the migrations:
   ```bash
   php artisan migrate
   ```
8. Serve the application:
   ```bash
   php artisan serve
   ```

## Usage

- Visit `http://localhost:8000` in your browser.
- Register a new user or log in with an existing account.

## License

This project is licensed under the MIT License.

---

This README provides an overview, setup instructions, and basic usage information for the project. Adjust the details as needed!
