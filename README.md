# Student Platform using Laravel 6 and Vue 2

A simple student platform / management single page application using Laravel and Vue.
Currently a work in progress.

## Features

-   Dashboard
-   To-Do List
-   Add assignments, exams
-   Custom weekly timetable
-   Calendar & events
-   View grades, courses, teachers
-   Admin Panel

## Requirements

-   [Composer](www.getcomposer.org)
-   [Node](www.nodejs.org)
-   [MySQL](www.mysql.com) or your preferred DBMS

## Installation

1. Clone the repo: `git clone https://github.com/umaraziz0/Student-Platform-SPA.git`
2. `cd` to the project folder
3. Install project dependencies: `composer install` and `npm install`
4. Save the `.env.example` as `.env` and set your database information
5. Generate the app key: `php artisan key:generate`
6. Run database migrations: `php artisan migrate`
7. Run the server: `php artisan serve` and `npm run dev`
