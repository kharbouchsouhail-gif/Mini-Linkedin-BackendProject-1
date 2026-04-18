# Mini LinkedIn - Backend Project

## Description
Mini LinkedIn is a backend REST API built with **Laravel 10**, designed to simulate
a professional networking and job application platform. It allows candidates to 
create profiles, browse job offers, and apply to them. Recruiters can post offers 
and manage applications. Admins can manage users and moderate offers.

Laravel 10 was chosen for this project because of its powerful built-in tools that 
boost developer productivity — such as automatic file generation via Artisan commands 
(controllers, models, migrations, events, listeners, and more), a clean routing system,
JWT authentication support, and a robust event/listener architecture that allows clean 
decoupling of application logic.

## Requirements
- PHP >= 8.1
- Composer
- MySQL
- Postman (for API testing)
- **Laravel 10** — used for its powerful Artisan CLI that automatically generates
  files (controllers, models, migrations, events, listeners, middleware and more)
  with a single command, saving development time and enforcing a clean structure.

## Tech Stack
- **Laravel 10** — PHP Framework
- **JWT Auth** — API Authentication (tymon/jwt-auth)
- **MySQL** — Database
- **Eloquent ORM** — Database interaction
- **Laravel Events & Listeners** — Decoupled application logic

## Installation Steps

1. **Clone the project**
   git clone https://github.com/KharbouchSouhail/Mini-Linkedin-BackendProject-1
   cd Mini-Linkedin

2. **Install dependencies**
   composer install

3. **Create environment file**
   cp .env.example .env

4. **Configure your database**
   Open .env and update:
   DB_DATABASE=your_database_name
   DB_USERNAME=your_username
   DB_PASSWORD=your_password

5. **Generate Laravel key**
   php artisan key:generate

6. **Generate JWT secret**
   php artisan jwt:secret

7. **Run migrations and seeders**
   php artisan migrate:fresh --seed

8. **Start the server**
   php artisan serve

## Roles
| Role      | Permissions                                      |
|-----------|--------------------------------------------------|
| candidat  | Create profile, browse offers, apply             |
| recruteur | Post offers, manage applications, update status  |
| admin     | Manage users, moderate offers                    |

## Testing
- API base URL: http://127.0.0.1:8000/api
- Use Postman to test endpoints
- Default password for all seeded users: password
- After applying to an offer or updating a status, check:
  storage/logs/candidatures.log

## Events & Listeners
This project implements Laravel's Event & Listener system to decouple logic:
- **CandidatureDeposee** — triggered when a candidate applies to an offer.
  Logs the candidate name and offer title to storage/logs/candidatures.log
- **StatutCandidatureMis** — triggered when a recruiter updates an application status.
  Logs the old status, new status and date to storage/logs/candidatures.log