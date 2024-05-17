# II. Backend
### Step 1: Install the Packages
- [x] cd .\backend\
> <code> composer install **or** composer i </code>

### Step 2: Update the Environment Variables
- [x] copy <code>.env.example </code> file **to** the <code>.env </code> file
```
DB_DATABASE= YOUR_DB_NAME
DB_USERNAME= root
```
### Step 3: Create app key
> <code> php artisan key:generate </code>

### Step 4: Create app key for JWT token

php artisan jwt:secret

### Step 5: Migrate migrateion table to database
> <code> php artisan migrate </code>

### Step 6: Migrate default admin user to database with seeder
> <code> php artisan db:seed </code>

### Step 7: Set up your email in .env file
#### Example:
```
MAIL_DRIVER=smtp
MAIL_HOST=smtp.googlemail.com
MAIL_PORT=587
MAIL_USERNAME=you@gmail.com
MAIL_PASSWORD=sadanfsnskadf
MAIL_ENCRYPTION=ssl
MAIL_FROM_ADDRESS=you@gmail.com
MAIL_FROM_NAME=
```

### Step 8: Running Application
- [x] If you are in local development environments
> <code> php artisan serve </code> --port=YOUR_PORT (port is optional) 

- [x] If you are in production environments
> <code> http:://YOUR_IP_ADDRESS:YOUR_PORT </code>
#### Example for <code>local development environments</code>:
```
http://127.0.0.1:8000
```

###### Aditional command ########
## 1.Installation:

composer install: Install project dependencies.
## 2.Environment Setup:

cp .env.example .env: Create a .env file from the example file.
php artisan key:generate: Generate an application key for encryption.
php artisan config:cache: Cache configuration files for faster loading.
## 3.Database Management:

php artisan migrate: Run pending migrations.
php artisan db:seed: Seed the database with records.
php artisan migrate:refresh --seed: Refresh the database and run all seeders.
## 4.Development & Debugging:

php artisan serve: Start the Laravel development server.
php artisan route:list: List all registered routes.
php artisan tinker: Interact with your application using Laravel's interactive shell.
## 5.Testing:

php artisan test: Run PHPUnit tests.
php artisan dusk: Run browser tests using Laravel Dusk.

## 6.Package Management:

composer require: Install a new package.
composer update: Update project dependencies.
composer dump-autoload: Regenerate the Composer autoloader.
## 7.Version Control:

git clone: Clone the repository.
git pull: Fetch and merge changes from the remote repository.
git push: Push changes to the remote repository.
git checkout: Switch branches or restore working tree files.
## 8.Miscellaneous:

php artisan make:*: Generate Laravel components (e.g., controllers, models, migrations).
php artisan help: Display help for Artisan commands.
php artisan list: List all available Artisan commands.
