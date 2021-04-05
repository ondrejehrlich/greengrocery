## About this repository

This is a project of an app for a shop with greengroceries that is sold by boxes. This project is made using [Laravel](https://laravel.com) and [Vue.js](https://vuejs.org).

I did not consider it necessary to use Vuex or a more sophisticated API calling system for such a small project.

## Installing by composer

Clone repository.

```bash
git clone https://github.com/ondrejehrlich/greengrocery.git
```

Install composer dependences.

```bash
composer install
```

You can install also npm dependences but it's not necessary to do that if you wanna just look at it and make no changes.

```bash
npm install
```

or

```bash
yarn
```

Then create .env file and copy the content of .env.example to it. You can do that with this command:

```bash
cat .env.example > .env
```

Fill in the data about your database into .env file. For example:

```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=greengrocery
DB_USERNAME=root
DB_PASSWORD=root
```

Generate key for encrypting.

```bash
php artisan key:generate
```

Migrate database and seed it with fake data.

```bash
php artisan migrate:fresh --seed
```

Run server:

```bash
php artisan serve
```

You should see something like this:

```
Starting Laravel development server: http://127.0.0.1:8000
```

Your server is listening on http://127.0.0.1:8000
