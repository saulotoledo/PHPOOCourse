# PHPOOCourse

This is a basic PHP course example code. In order to run it, you need to:

  1. Have a MySQL/MariaDB instance running;
  2. Configure the database connection params at **app/config/database.php** (or create the file **app/config/database.local.php** with the same configuration);
  3. Run the create database script (be sure to configure an user with proper rights at previous step):

        > php createDatabase.php
  4. Run the project. For example:

        > php -S localhost:8888 -t web/
