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
   git clone https://github.com/balqisstudy/golf-tournament
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

- **Always pull the latest changes before starting work:**
  ```bash
  git pull origin main
  ```
- **Create a new branch for each feature or bugfix:**
  ```bash
  git checkout -b feature/your-feature-name
  ```
- **Commit your changes with clear messages:**
  ```bash
  git add .
  git commit -m "your descriptive commit message"
  ```
- **Push your branch to GitHub:**
  ```bash
  git push origin feature/your-feature-name
  ```
- **Open a Pull Request on GitHub** for review and merging.
- **If working directly on main (not recommended):**
  - Always pull before you start:
    ```bash
    git pull origin main
    ```
  - Add, commit, and push your changes:
    ```bash
    git add .
    git commit -m "your descriptive commit message"
    git push origin main
    ```
- Review and testing by other collaborators before merging to `main`.

## Contribution Guidelines

- Follow PSR-12 coding standards.
- Write tests for new features.
- Keep documentation up to date.

## License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
