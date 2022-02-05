# Storage-Management-Template
a template for storage management website where the admin can do the following :

1.create companies.
2.create storages for those companies.
3.create users to handle data entry.
4.access an archive of the data that had been deleted.

## To start of :


### 1.Upload the database :
  - create a new database
  - upload the mysql file into the database
  - go to the file Config.php and replace "storage_website" with the name of your database : 
    ```
    Define('DB_dsn', 'mysql:dbname=storage_website;host='.Host_Name);
    ```
### 2.Set up the dsn string
  - in Config.php enter your database user name and password :
  ```
    Define('DB_user', 'root');
    Define('DB_password', '');
  ```
### 3.Change the host name :
  - in Config.php edit the following : 
  ```
   define('Host_Name', 'localhost');
  ```
  
### 4.Set up your admin name and password
  - in Config.php edit the following :
  ```
  Define('Admin_name', 'Admin');
  Define('Admin_Password', 'Password');
  ```
