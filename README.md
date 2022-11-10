## **Getting started**
___
### Prerequisites
```
PHP 8 with MySQL
```

### Installation
Clone the repository
```
git clone https://github.com/patelajay053/ajay-aspire.git
```

Switch to the repo folder
```
cd ajay-aspire
```

Install all the dependencies using composer
```
composer install
```

Copy the example env file and make the required configuration changes in the .env file
```
cp .env.example .env
```

Generate a new application key if it is not generated
```
php artisan key:generate
```

Run the database migrations
```
php artisan migrate
```

### Database seeding
The database seeding initially add customer & admin data into database. This can help you to quickly start testing the api
```
php artisan module:seed Customers
php artisan module:seed Admin
```

After run seeding, in the database customer and admin is created using below details.
**Customer Detail**
``Email: patel.ajay053@gmail.com``
``Password: Ajay@123``

**Admin Detail**
``Email: admin@localhost.com``
``Password: Ajay@123``

### Postman Collection for API
Please import below postman collection and use it.
```
https://www.getpostman.com/collections/bd6ca5fa2a7058bc8e0f
```

In the postman please set enviroment with below variable
- url (For ex: http://localhost:8000/)
- customer_token
- admin_token

### Running the Scheduler
In this app one command is scheduled to run on every day at 4:00 PM and EMI which have a payment date is mark as paid automatically on that day. **Note:** There is no payment flow in this app so didn't check payment confirmation. **Please add below command in to cron.**
```
* * * * * cd /path-to-your-project && php artisan schedule:run >> /dev/null 2>&1
```

### Tests
Composer file contain test command, so for run tests please run below command
```
composer test
```