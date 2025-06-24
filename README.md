# Golf Tournament Group Project

This is a group project built with Laravel for managing golf tournaments. It provides features for player management, tournament scheduling, and scoring.

## Prerequisites

- PHP >= 8.2
- Composer
- Node.js & npm
- Git
- (Optional) SQLite, MySQL, or other supported database

## Setup Instructions

1. **Clone the repository:**
   ```bash
   git clone <your-repo-url>
   cd golf-tournament
   ```

2. **Install PHP dependencies:**
   ```bash
   composer install
   ```

3. **Install Node dependencies:**
   ```bash
   npm install
   ```

4. **Set up environment variables:**
   - Copy the example environment file:
     ```bash
     cp .env.example .env
     ```
   - Edit `.env` to configure your database and other settings as needed.

5. **Generate application key:**
   ```bash
   php artisan key:generate
   ```

6. **Set up the database:**
   - Ensure your database is created and configured in `.env`.
   - Run migrations:
     ```bash
     php artisan migrate
     ```

7. **(Optional) Seed the database:**
   ```bash
   php artisan db:seed
   ```

8. **Run the development servers:**
   - Start Laravel backend:
     ```bash
     php artisan serve
     ```
   - Start Vite frontend (in a new terminal):
     ```bash
     npm run dev
     ```
   - Or use the combined dev script:
     ```bash
     composer run dev
     ```

## Running Tests

```bash
php artisan test
```

## Git & Collaboration Workflow

- Create a new branch for each feature or bugfix:
  ```bash
  git checkout -b feature/your-feature-name
  ```
- Commit your changes with clear messages.
- Push your branch and open a Pull Request on GitHub.
- Review and testing by other collaborators before merging to `main`.

## Contribution Guidelines

- Follow PSR-12 coding standards.
- Write tests for new features.
- Keep documentation up to date.

## License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
