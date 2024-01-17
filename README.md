## Task Management

How to install and use:
1. Clone the repository
2. RUn `cp .env-example .env`
3. Run `composer install`
4. Run `npm install`
5. Run `php artisan migrate`(agree to create task_management table)
6. Run `php artisan db:seed` and `php artisan db:seed --class=TaskTableSeeder`
7. Run `npm run build`

Test account:
email: test@gmail.com
password: testing1234