# University Management CRUD

## How to run?

You need a php interpreter and MySQL

## Database setup

You must first create the database and required tables/views. To do this. I provided two scripts: `tableDefinitions.sql`, `createViews`.sql and `fillTable`.sql (inserts mock data into db)

## PHP setup

The database settings must be provided in the code, at `mysqli_connect.php`. Fill in your MySql data in these lines

```php
DEFINE('DB_USER', 'root');
DEFINE('DB_PASSWORD', '');
DEFINE('DB_HOST', 'localhost');
DEFINE('DB_NAME', 'crud_project');
```



I suggest using Apache. Drop this repository inside the correct folder and access localhost.
