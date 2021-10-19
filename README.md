## Invoice Generator

This is an invoice generator web application based on a product list. The stack used is as follows:

- Laravel v8.0
- Bootstrap v4.0
- MySQL

Please check the app flux diagram by clicking [here](https://app.box.com/s/n48tujbd5ocywlcrr2cchkbz3fkzgz1f)

## Getting started
These instructions will get you a copy of the project up and running on your local machine for development and testing purposes.

### Prerequisites
You need the following resources:
- [Composer](https://getcomposer.org/)
- [Node.js](https://nodejs.org/en/)
- MySQL database
- LAMP or LEMP server

### Installation
1. Duplicate the file ```.env.example``` as ```.env``` and set your credential for the database in:
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=database_name
DB_USERNAME=root
DB_PASSWORD=
```
2. Then install the PHP packages
```
composer install
```
3. Generate the application key:
```
php artisan key:generate
```
4. Install the JavaScript packages with npm
```
npm install
```
5. Finally generate the database with fake data:
```
php artisan migrate --seed
```
## Running the project
First generate the public files with

```
npm run dev
```

Note: Each time SASS and JavaScript files are updated you need to run the past command, to make it easier run:

```
npm run watch
```

Finally run the serve

```
php artisan serve
```

## Deployment

To deploy the project you need extra configurations for optimization and security as:

Generate optimized JavaScript files.

```
npm run production
```

Set in the file .env the next configuration.

```
APP_ENV=production
```
## Built With

-   [Laravel 8.0](https://laravel.com/docs/8.x/) - Framework PHP.
## Author

-   Daniel Gonzalez -  [odagora](https://github.com/odagora)
## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
