


# Setup
```bash
sudo apt-get update
sudo apt-get install nginx mariadb-server php-fpm php-mysql
sudo mysql -e "UPDATE mysql.user SET Password = PASSWORD('12345') WHERE User = 'root'"
sudo mysql -e "DELETE FROM mysql.user WHERE User='';"
sudo mysql -e "DELETE FROM mysql.user WHERE User='root' AND Host NOT IN ('localhost', '127.0.0.1', '::1');"
sudo mysql -e "DROP DATABASE IF EXISTS test;"
sudo mysql -e "DELETE FROM mysql.db WHERE Db='test' OR Db='test\\_%';"
sudo mysql -e "create database contactbook";
sudo mysql -e "CREATE USER 'admin'@'localhost' IDENTIFIED BY 'admin'";
sudo mysql -e "GRANT ALL PRIVILEGES ON contactbook . * TO 'admin'@'localhost'";
sudo mysql -e "FLUSH PRIVILEGES";

sudo mysql contactbook<db.sql


```

# Set up a flag

```
sudo mysql -e "insert into contactbook.flag(\`id\`) values ('SQL_Injection_Contact');";
```
