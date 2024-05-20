
1. Clone the repository:

   ```bash
   git clone https://github.com/karan-zignuts/user-permission-role-module-project.git
   ```

2. Change the working directory:

   ```bash
   cd user-permission-role-module
   ```

3. Install PHP dependencies using Composer:

   ```bash
   composer install
   ```

4. Create a copy of the `.env.example` file and rename it to `.env`. Update the file with your database configuration and mail settings.

5. Generate an application key:

   ```bash
   php artisan key:generate
   ```

6. Migrate the database:

   ```bash
   php artisan migrate
   ```

7. Database Seeding:

   ```bash
   php artisan db:seed
   ```

8. Install npm packages:
```bash 
  npm install 
```

9. After installing npm packages to run this command:

  ```bash
    npm run dev
  ```

10. Start the development server:

   ```bash
   php artisan serve
   ```

Visit http://localhost:8000 in your web browser to access the application.

## Database Setup

Configure your database connection in the `.env` file.

```dotenv
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database_name
DB_USERNAME=root
DB_PASSWORD=your_password
```

## Email Configuration

Email settings in the `.env` file. 

```dotenv
MAIL_MAILER=smtp
MAIL_HOST=sandbox.smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=youremail@gmail.com
MAIL_PASSWORD=your_password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=youremail@gmail.com
MAIL_FROM_NAME="${APP_NAME}"
```
