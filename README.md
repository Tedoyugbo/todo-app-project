## About Todo App

# Todo-app
This is a Full Stack Todo Application for task creation, and update, it was. built with laravel and livewire 

## Table of Contents

-   [Technologies](#technologies)
-   [Getting Started](#getting-started)
    -   [Installation](#installation)
    -   [Third Party Packages](#third-party-packages)
    -   [Usage](#usage)
    -   [Security Vulnerabilities](#security-vulnerabilities)
    -   [License](#license)

## Technologies
-   [Laravel](https://laravel.com/) - Laravel is a web application framework with expressive, elegant syntax.
-   [Livewire](https://laravel-livewire.com/) - Livewire is a full-stack framework for Laravel that makes building dynamic interfaces simple, without leaving the comfort of Laravel.
-   [Node](https://nodejs.org/en/) - Node.js® is an open-source, cross-platform JavaScript runtime environment.
-   [Docker](https://www.docker.com/) - Docker is a platform designed to help developers build, share, and run modern applications. We handle the tedious setup, so you can focus on the code.


## Getting Started

### Installation

####  New Project

```bash
-   git clone [https://github.com/Tedoyugbo/todo-app-project](https://github.com/Tedoyugbo/todo-app-project)
-   Run `composer install` to install packages.
-   Docker installation is optional.
-   There is `docker-compose.yml` file for starting Docker, run `docker-compose up` to start the container.
-   Copy .env.example file, create a .env file if not created and edit database credentials there.  
-   Run `alias sail='[ -f sail ] && sh sail || sh vendor/bin/sail'` to configure a shell alias that allows you to execute Sail's commands more easily
-   (Docker) Run `sail up` to start up app in docker.
-   (No-Docker) Run `php artisan serve` to start up app locally.
-   (Docker) Run `sail php artisan migrate:fresh --seed` to migrate database and seed the Pre-defined Factory data into it.
-   (No-Docker) Run `php artisan migrate:fresh --seed` to migrate database and seed the Pre-defined Factory data into it.
-   (Docker)Run `sail npm run dev` to bootstrap vite for frontend html, css and js.
-   (No-Docker)Run `sail npm run dev` to bootstrap vite for frontend html, css and js.
Setup Docker With Sail 
```

##### Old Laravel Project Without Sail

```bash
- composer install 
- php artisan sail:install
- ./vendor/bin/sail up
- [configure a shell alias that allows you to execute Sail\'s commands more easily]()
    - alias sail='[ -f sail ] && sh sail || sh vendor/bin/sail'
    - sail up
- [To run in Background]()
    - sail up -d
- [To Stop Docker]()
    - sail stop

- To Setup PHP Application Container within Docker 
    - RUN THE COMMAND BELOW AS IT IS
    - docker run --rm \
        -u "$(id -u):$(id -g)" \
        -v "$(pwd):/var/www/html" \
        -w /var/www/html \
        laravelsail/php81-composer:latest \
        composer install --ignore-platform-reqs
    - sail composer install
    - [Scaffold Bootstrap with vite]() sail npm run dev
    - sail php artisan migrate:fresh --seed
    - sail php artisan optimize:clear
```
### THIRD PARTY PACKAGES

- **[Turbo Links](https://github.com/turbolinks/turbolinks)**
- **[Bootstrap](https://getbootstrap.com/)**
- **[Toaster.JS](https://cdnjs.com/libraries/toastr.js/latest)**


### Usage

This is the basic flow of the application.
#### USER Section

- 1. User can Login
- 2. User can Register
#### TASK Section

- 1. User can View all his tasks
- 2. User can Update his task status
- 3. User can delete task

### Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Trust Edoyugbo via [trust.edoyugbo@yahoo.com](mailto:trust.edoyugbo@yahoo.com). All security vulnerabilities will be promptly addressed.

### License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
