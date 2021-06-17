


# Setup
```bash
sudo apt-get update
sudo apt-get install nginx mariadb-server php-fpm php-mysql
sudo mysql -e "UPDATE mysql.user SET Password = PASSWORD('12345') WHERE User = 'root'"
sudo mysql -e "DELETE FROM mysql.user WHERE User='';"
sudo mysql -e "DELETE FROM mysql.user WHERE User='root' AND Host NOT IN ('localhost', '127.0.0.1', '::1');"
sudo mysql -e "DROP DATABASE IF EXISTS test;"
sudo mysql -e "DELETE FROM mysql.db WHERE Db='test' OR Db='test\\_%';"
sudo mysql -e "create database secrets";
sudo mysql -e "CREATE USER 'admin'@'localhost' IDENTIFIED BY 'admin'";
sudo mysql -e "GRANT ALL PRIVILEGES ON secrets.* TO 'admin'@'localhost'";
sudo mysql -e "FLUSH PRIVILEGES";
```





There is lack of authorization in posts edit. 
1. Register new user
2. Create new secret paste
3. Edit it and change it's ID to 15

There you will see other user paste!

Find post with id = 15 - saLuxUBroMBU