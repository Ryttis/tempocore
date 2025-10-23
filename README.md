# 🕓 TempoCore — Laravel Booking & Availability System

TempoCore is a modular booking engine built on Laravel, following Domain-Driven Design (DDD) principles.  
It provides availability computation, appointment scheduling, and working hour management through a RESTful API.

---

## 🚀 Features

- Availability calculation (based on working hours, appointments, exceptions)
- Appointment management with holds and provider settings
- REST API with validation and DTO mapping
- Domain-driven architecture (Application / Domain / Infrastructure / Interface layers)
- Vue 3 frontend with Vite
- PHPUnit + Laravel test suite

---

## 🧩 Project Structure

```bash
app/
├── Application/DTO/               # Data Transfer Objects
├── Domain/                        # Core business logic
├── Infrastructure/                # Eloquent models & repositories
├── Interfaces/Http/               # Controllers & Requests
├── Services/                      # Application services (Booking, Availability)
bootstrap/
config/
database/
resources/js/                      # Vue components and pages
routes/
```

## ⚙️ Requirements

- PHP 8.2 or higher
- Composer
- Node.js 18+ & npm
- MySQL or PostgreSQL
- Laravel 11.x

---

## 🛠️ Installation

```bash
# 1. Clone the repository
git clone https://github.com/your-username/tempocore.git
cd tempocore

# 2. Install dependencies
composer install
npm install && npm run build

# 3. Set up environment
cp .env.example .env
php artisan key:generate

# 4. Configure your database in .env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=tempocore
DB_USERNAME=root
DB_PASSWORD=

# 5. Run migrations and seeders
php artisan migrate --seed

Ensure required directories exist if not install:
mkdir -p storage/framework/{cache,sessions,views} storage/logs bootstrap/cache
# 6. Start local server
php artisan serve

Open your browser at http://localhost:8000
```
# Run feature and unit tests
```
php artisan test

# or with PHPUnit directly
vendor/bin/phpunit
```
## 🧹 Code Quality
### Auto-format code
```bash

vendor/bin/php-cs-fixer fix
```

### Static analysis
```bash

vendor/bin/phpstan analyse
```

## 🧱 API Overview
Base URL: http://localhost:8000/api


| Endpoint         | Method     | Description                    |
|------------------|------------|--------------------------------|
| `/availability`  | **GET**    | Retrieve available time slots  |
| `/appointments`  | **POST**   | Create new appointment         |
| `/working-hours` | **GET/POST** | Manage provider working hours  |
| `/services`      | **GET**    | List available services        |

## 🧑‍💻 Frontend
The Vue.js frontend (located in resources/js/) uses Vite for development:
```bash

npm run dev
```
Visit http://localhost:5173

## 📦 Deployment
For production:
````bash

npm run build
php artisan config:cache
php artisan route:cache
php artisan migrate --force


