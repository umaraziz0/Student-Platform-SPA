# :mortar_board: Student Platform using Laravel 6 and Vue 2

A simple student platform / management single page application using Laravel and Vue.
Currently a work in progress.

## :star: Features

-   Dashboard
-   To-Do List
-   Add assignments, exams
-   Custom weekly timetable
-   Calendar & events
-   View grades, courses, teachers
-   Admin Panel

## :exclamation: Requirements

-   [Composer](https://www.getcomposer.org)
-   [Node](https://www.nodejs.org)
-   [MySQL](https://www.mysql.com) or your preferred DBMS

## :arrow_down: Installation

1. Clone the repo: `git clone https://github.com/umaraziz0/Student-Platform-SPA.git`
2. `cd` to the project folder
3. Install project dependencies: `composer install` and `npm install`
4. Save the `.env.example` as `.env` and set your database information
5. Generate the app key: `php artisan key:generate`
6. Run database migrations: `php artisan migrate`
7. Run seeder: `php artisan db:seed`, which will create 2 accounts:
    1. Admin 
        - Student ID: 0
        - Password: admin1234
        - will login into the Admin Panel
    2. Student
        - Student ID: 1
        - Password: student1234
        - will login into the student dashboard
8. Run the server: `php artisan serve` and `npm run dev`
