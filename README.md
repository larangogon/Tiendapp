# TiendApp

## Installation
- **Install a server side application. Example: Xampp, Wamp, Lampp, etc.**
- **Clone the repository on the root. (htdocs for xampp, www for laragon and wamp, etc).**
- **Open terminal and run the following commands:**
    * -cd TiendasApp
    * -composer install
    * -npm install
    * -npm run dev
    * -cp .env.example .env
    * -set up email

- **Create database JAM:**
    * -mysql -u root
    * -create database tiendasapp;
    * -exit
    * -php artisan migrate --seed

- **Create database test:**
    * -mysql -u root
    * -create database testing_laravel;
    * -exit

- **Open terminal and run the following commands-test:**
    * -cp .env.testing.example .env
    * -php artisan test

- **To finish and deploy the application, run the command:**
    * -php artisan optimize:clear
    * -php artisan serve

- **Login Admin.**
    * -(user: admin@example.com, password: 123).

     
