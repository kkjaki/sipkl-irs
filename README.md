# SIPKL-IRS (Sistem Informasi Praktek Kerja Lapangan - Internship Record System)

A web-based internship management system for industries (companies) to manage their internship programs, partner schools, students, mentors, attendance, and grading.

## Tech Stack

| Layer      | Technology                                        |
| ---------- | ------------------------------------------------- |
| Framework  | **Laravel 12** (PHP 8.2+)                         |
| Database   | **MySQL** (`sipkl-irs`)                           |
| Frontend   | **Blade** + **Vite** + **Tailwind CSS**           |
| Auth       | **Laravel Breeze** (session-based)                |
| Icons      | Blade Lucide Icons, Blade Heroicons               |
| Testing    | Pest PHP                                          |
| Queue/Cache| Database driver                                   |

---

## User Roles

Defined as an enum on the `users` table: **`admin`**, **`owner`**, **`mentor`**, **`student`**.

| Role      | Description                                                    |
| --------- | -------------------------------------------------------------- |
| `admin`   | System administrator                                           |
| `owner`   | Industry/company owner — creates and manages their industry    |
| `mentor`  | Industry employee who supervises students on-site              |
| `student` | Intern who registers via invitation code                       |

---

## Database Schema

### Entity Relationship Diagram (text)

```
User (1)──────(1) Industry       (owner)
User (1)──────(1) Mentor
User (1)──────(1) Student
User (1)──────(∞) AttendanceSession (opened_by)

Industry (1)──(∞) InternshipProgram
Industry (1)──(∞) School           (partner schools)
Industry (1)──(∞) AttendanceSession
Industry (1)──(∞) Mentor

InternshipProgram (1)──(∞) Student

School (1)────(∞) Student
School (1)────(∞) SchoolSupervisor
School (1)────(∞) Criterion

SchoolSupervisor (1)──(∞) Student

Criterion (1)──(∞) Grade
Student   (1)──(∞) Grade

AttendanceSession (1)──(∞) Attendance
Student           (1)──(∞) Attendance
```

### Tables

#### `users`
| Column              | Type                                        | Notes                   |
| ------------------- | ------------------------------------------- | ----------------------- |
| `id`                | bigint (PK)                                 |                         |
| `name`              | string                                      |                         |
| `email`             | string (unique)                             |                         |
| `email_verified_at` | timestamp (nullable)                        |                         |
| `password`          | string (hashed)                             |                         |
| `role`              | enum: admin, owner, mentor, student         | default: `student`      |
| `is_active`         | boolean                                     | default: `true`         |
| `remember_token`    | string                                      |                         |
| `timestamps`        |                                             |                         |

#### `industries`
| Column     | Type                | Notes                        |
| ---------- | ------------------- | ---------------------------- |
| `id`       | bigint (PK)         |                              |
| `owner_id` | FK → `users.id`     | cascade delete               |
| `name`     | string              |                              |
| `address`  | text (nullable)     |                              |
| `phone`    | string(15) nullable |                              |
| `timestamps` |                  |                              |

#### `internship_programs`
| Column            | Type                  | Notes                       |
| ----------------- | --------------------- | --------------------------- |
| `id`              | bigint (PK)           |                             |
| `industry_id`     | FK → `industries.id`  | cascade delete              |
| `name`            | string                |                             |
| `start_date`      | date                  |                             |
| `end_date`        | date                  |                             |
| `invitation_code` | string (unique)       | used by students to join    |
| `is_active`       | boolean               | default: `true`             |
| `timestamps`      |                       |                             |

**Indexes:** `(industry_id, is_active)`, `(start_date, end_date)`

#### `mentors`
| Column        | Type                 | Notes           |
| ------------- | -------------------- | --------------- |
| `id`          | bigint (PK)          |                 |
| `user_id`     | FK → `users.id`      | cascade delete  |
| `industry_id` | FK → `industries.id` | cascade delete  |
| `position`    | string               |                 |
| `timestamps`  |                      |                 |

#### `schools`
| Column        | Type                 | Notes               |
| ------------- | -------------------- | ------------------- |
| `id`          | bigint (PK)          |                     |
| `industry_id` | FK → `industries.id` | cascade delete      |
| `name`        | string               |                     |
| `address`     | text (nullable)      |                     |
| `phone`       | string(15) nullable  |                     |
| `timestamps`  |                      |                     |

#### `school_supervisors`
| Column       | Type               | Notes          |
| ------------ | ------------------ | -------------- |
| `id`         | bigint (PK)        |                |
| `school_id`  | FK → `schools.id`  | cascade delete |
| `name`       | string             |                |
| `phone`      | string(15) nullable|                |
| `timestamps` |                    |                |

#### `students`
| Column                 | Type                             | Notes               |
| ---------------------- | -------------------------------- | -------------------- |
| `id`                   | bigint (PK)                      |                      |
| `user_id`              | FK → `users.id`                  | cascade delete       |
| `internship_program_id`| FK → `internship_programs.id`    | cascade delete       |
| `school_id`            | FK → `schools.id` (nullable)     | cascade delete       |
| `school_supervisor_id` | FK → `school_supervisors.id` (nullable) | cascade delete |
| `nis`                  | string(20) unique nullable       | student ID number    |
| `class`                | string(30) nullable              |                      |
| `address`              | text (nullable)                  |                      |
| `phone`                | string(15) nullable              |                      |
| `hobby`                | string(64) nullable              |                      |
| `timestamps`           |                                  |                      |

#### `criteria`
| Column        | Type                 | Notes          |
| ------------- | -------------------- | -------------- |
| `id`          | bigint (PK)          |                |
| `industry_id` | FK → `industries.id` | cascade delete |
| `school_id`   | FK → `schools.id`    | cascade delete |
| `name`        | string               |                |
| `description` | text (nullable)      |                |
| `timestamps`  |                      |                |

#### `grades`
| Column        | Type                  | Notes          |
| ------------- | --------------------- | -------------- |
| `id`          | bigint (PK)           |                |
| `criteria_id` | FK → `criteria.id`    | cascade delete |
| `student_id`  | FK → `students.id`    | cascade delete |
| `score`       | integer               | default: `0`   |
| `timestamps`  |                       |                |

#### `attendance_sessions`
| Column              | Type                 | Notes               |
| ------------------- | -------------------- | ------------------- |
| `id`                | bigint (PK)          |                     |
| `industry_id`       | FK → `industries.id` | cascade delete     |
| `opened_by_user_id` | FK → `users.id`      | cascade delete     |
| `session_date`      | date                 |                     |
| `on_time_deadline`  | time                 |                     |
| `closed_at`         | time (nullable)      |                     |
| `is_open`           | boolean              | default: `true`     |
| `timestamps`        |                      |                     |

#### `attendances`
| Column                  | Type                             | Notes                                    |
| ----------------------- | -------------------------------- | ---------------------------------------- |
| `id`                    | bigint (PK)                      |                                          |
| `attendance_session_id` | FK → `attendance_sessions.id`    | cascade delete                           |
| `student_id`            | FK → `students.id`               | cascade delete                           |
| `status`                | enum: hadir, izin, sakit, alpa   | default: `alpa` (absent)                 |
| `check_in`              | timestamp (nullable)             |                                          |
| `notes`                 | text (nullable)                  |                                          |
| `timestamps`            |                                  |                                          |

**Status values:** `hadir` = present, `izin` = permitted leave, `sakit` = sick, `alpa` = absent (unexcused)

---

## Project Structure

```
sipkl-irs/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Auth/                        # Breeze auth controllers + StudentRegistrationController
│   │   │   ├── AttendanceController.php     # Validate/update attendance records
│   │   │   ├── AttendanceSessionController.php # Open/close attendance sessions
│   │   │   ├── CriterionController.php      # CRUD grading criteria (nested under schools)
│   │   │   ├── GradeController.php          # View & assign grades per student per school
│   │   │   ├── InternshipProgramController.php # CRUD internship programs
│   │   │   ├── MentorController.php         # CRUD mentors + activate/deactivate
│   │   │   ├── ProfileController.php        # User profile management
│   │   │   ├── SchoolController.php         # CRUD partner schools + management view
│   │   │   └── SchoolSupervisorController.php # CRUD school supervisors (nested under schools)
│   │   └── Requests/                        # Form request validation classes
│   ├── Models/
│   │   ├── Attendance.php
│   │   ├── AttendanceSession.php
│   │   ├── Criterion.php
│   │   ├── Grade.php
│   │   ├── Industry.php
│   │   ├── InternshipProgram.php
│   │   ├── Mentor.php
│   │   ├── School.php
│   │   ├── SchoolSupervisor.php
│   │   ├── Student.php
│   │   └── User.php
│   └── View/                                # View composers / shared data
├── database/
│   ├── migrations/                          # 13 migration files
│   └── seeders/
│       ├── DatabaseSeeder.php               # Calls: UserSeeder, IndustrySeeder, SchoolSeeder
│       ├── DummyDataSeeder.php              # Creates test owner + industry
│       ├── UserSeeder.php
│       ├── IndustrySeeder.php
│       └── SchoolSeeder.php
├── resources/views/
│   ├── auth/                                # Login, register, password reset views
│   ├── components/                          # Reusable Blade components
│   ├── dashboard.blade.php                  # Main dashboard
│   ├── industry/                            # Industry management views
│   │   ├── dashboard.blade.php
│   │   ├── mentors/                         # Mentor CRUD views
│   │   ├── programs/                        # Internship program views
│   │   ├── schools/                         # School CRUD views
│   │   └── supervisors/                     # Supervisor views
│   ├── layouts/                             # App layout templates
│   ├── partials/                            # Shared partials
│   ├── profile/                             # Profile edit views
│   └── welcome.blade.php                    # Landing page
├── routes/
│   ├── web.php                              # Main web routes (all behind auth middleware)
│   └── auth.php                             # Breeze authentication routes
├── composer.json
├── package.json
├── tailwind.config.js
└── vite.config.js
```

---

## Routes Summary

### Public Routes
| Method | URI                   | Description                     |
| ------ | --------------------- | ------------------------------- |
| GET    | `/`                   | Welcome / landing page          |
| GET    | `/csrf-token`         | Returns CSRF token as JSON      |
| GET    | `/register/student`   | Student self-registration form  |
| POST   | `/register/student`   | Store student registration      |

### Authenticated Routes (require login)
| Method   | URI                                              | Name                        | Description                         |
| -------- | ------------------------------------------------ | --------------------------- | ----------------------------------- |
| GET      | `/dashboard`                                     | `dashboard`                 | Main dashboard                      |
| Resource | `/schools`                                       | `schools.*`                 | Full CRUD for schools               |
| GET      | `/schools/management`                            | `schools.management`        | School management view              |
| Resource | `/schools/{school}/supervisors`                  | `supervisors.*`             | Nested CRUD for supervisors         |
| Resource | `/schools/{school}/criteria`                     | `criteria.*`                | Nested CRUD for grading criteria    |
| Resource | `/mentors`                                       | `mentors.*`                 | CRUD for mentors (except show)      |
| POST     | `/mentors/{mentor}/deactivate`                   | `mentors.deactivate`        | Deactivate a mentor                 |
| POST     | `/mentors/{mentor}/activate`                     | `mentors.activate`          | Activate a mentor                   |
| Resource | `/internship-programs`                           | `internship-programs.*`     | Full CRUD for internship programs   |
| GET      | `/attendance-sessions`                           | `attendance-sessions.index` | List attendance sessions            |
| POST     | `/attendance-sessions`                           | `attendance-sessions.store` | Open new attendance session         |
| PATCH    | `/attendance-sessions/{session}/close`           | `attendanceSessions.close`  | Close an attendance session         |
| GET      | `/attendance-sessions/{session}/validate`        | `attendance.validate.show`  | View attendance for validation      |
| PUT      | `/attendance-sessions/{session}/validate`        | `attendance.validate.update`| Update/validate attendance          |
| GET      | `/grades/schools`                                | `grades.schools.index`      | List schools for grading            |
| GET      | `/grades/schools/{school}`                       | `grades.schools.show`       | View students in school for grading |
| GET      | `/grades/schools/{school}/student/{student}`     | `grades.schools.edit`       | Edit student grades                 |
| PUT      | `/grades/schools/{school}/student/{student}`     | `grades.schools.update`     | Save student grades                 |
| GET      | `/industry`                                      | `industry`                  | Industry dashboard                  |
| *        | `/profile`                                       | `profile.*`                 | View/update/delete profile          |

### Auth Routes (Breeze)
Standard Laravel Breeze routes: login, register, logout, password reset, email verification, password confirm.

---

## Getting Started

### Prerequisites
- PHP 8.2+
- Composer
- Node.js & npm
- MySQL

### Installation

```bash
# Clone the repository
git clone <repo-url> sipkl-irs
cd sipkl-irs

# Install PHP dependencies
composer install

# Install Node dependencies
npm install

# Environment setup
cp .env.example .env
php artisan key:generate

# Configure .env with your database credentials:
# DB_DATABASE=sipkl-irs
# DB_USERNAME=root
# DB_PASSWORD=

# Run migrations
php artisan migrate

# (Optional) Seed with test data
php artisan db:seed
```

### Running Locally

```bash
# Start all services (server + queue + logs + vite) concurrently:
composer dev

# Or individually:
php artisan serve        # Laravel dev server
npm run dev              # Vite dev server
```

---

## Key Business Logic

1. **Industry Owner** creates their Industry, then adds Schools, Mentors, and Internship Programs.
2. Each **Internship Program** has a unique `invitation_code` that students use to self-register.
3. **Schools** are partner schools. Each school can have **Supervisors** and **Criteria** (grading rubrics).
4. **Students** register via the public registration form, linking to a program and optionally a school/supervisor.
5. **Attendance** is managed through **Sessions** — an owner/mentor opens a session for a date, students are marked, then the session is closed.
6. **Grading** is done per student per criterion. Criteria are scoped to a specific industry + school pair.
