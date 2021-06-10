


# Setup
```bash
sudo apt-get update
sudo apt-get install nginx mariadb-server php-fpm php-mysql
mysql -e "UPDATE mysql.user SET Password = PASSWORD('12345') WHERE User = 'root'"
mysql -e "DELETE FROM mysql.user WHERE User='';"
mysql -e "DELETE FROM mysql.user WHERE User='root' AND Host NOT IN ('localhost', '127.0.0.1', '::1');"
mysql -e "DROP DATABASE IF EXISTS test;"
mysql -e "DELETE FROM mysql.db WHERE Db='test' OR Db='test\\_%';"
mysql -e "create database contactbook";
mysql -e "CREATE USER 'admin'@'localhost' IDENTIFIED BY 'admin'";
mysql -e "GRANT ALL PRIVILEGES ON contactbook . * TO 'admin'@'localhost'";
mysql -e "FLUSH PRIVILEGES";

mysql contactbook < db.sql


```

# Set up a flag

```
mysql -e "insert into pictures.flag(\`id\`) values ('YOUR_FLAG');";
```
