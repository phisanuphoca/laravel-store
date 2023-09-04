## API Backend implemented with Laravel 10

This project is a test of using Laravel to create a backend API for managing product orders. It involves data management, access control, and utilizing various Laravel features. There is no frontend in this project.

The features used in this project include:

-   Eloquent
-   API Resources
-   Middleware
-   Laravel Sanctum of authentication and authorization
-   Laravel Socialite : facebook, google verify access token
-   Cache: Redis
-   Events & Listeners
-   Queue
-   Database: MySQL
-   Database transaction
-   log request
-   unit test
-   Mail

## Installation

clone this project

```bash
git clone https://github.com/phisanuphoca/laravel-store.git
```

```bash
cd laravel-store
```

#### Setup

-   When you are done with installation, copy the `.env.example` file to `.env`
-   Install

```bash
composer install
```

#### Deploy Project on Docker using Laravel Sail

```bash
./vendor/bin/sail up
```

configure a shell alias that allows you to execute Sail's commands more easily:

```bash
alias sail='[ -f sail ] && sh sail || sh vendor/bin/sail'
```

Once the shell alias has been configured, you may execute Sail commands by simply typing sail. The remainder of this documentation's examples will assume that you have configured this alias:

```bash
sail up
```

### Prerequisites

Be sure to fill in your database details in your `.env` file before running the migrations:

```bash
sail artisan migrate
```

Can use mockup data

```bash
sail artisan db:seed
```

will create product and category data, along with 3 user accounts, as follows:

-   Admin

```
   Email: admin@store.com
   Password: password
```

-   Editor

```
   Email: editor@store.com
   Password: password
```

-   Viewer

```
   Email: viewer@store.com
   Password: password
```

You can edit this user test data in the `UsersSeeder.php` file.
