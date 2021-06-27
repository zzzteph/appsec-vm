

# Setup
```bash
sudo apt-get update
sudo apt-get install nginx mariadb-server php-fpm php-mysql
sudo mysql -e "UPDATE mysql.user SET Password = PASSWORD('12345') WHERE User = 'root'"
sudo mysql -e "DELETE FROM mysql.user WHERE User='';"
sudo mysql -e "DELETE FROM mysql.user WHERE User='root' AND Host NOT IN ('localhost', '127.0.0.1', '::1');"
sudo mysql -e "DROP DATABASE IF EXISTS test;"
sudo mysql -e "DELETE FROM mysql.db WHERE Db='test' OR Db='test\\_%';"
sudo mysql -e "create database pictures";
sudo mysql -e "CREATE USER 'admin'@'localhost' IDENTIFIED BY 'admin'";
sudo mysql -e "GRANT ALL PRIVILEGES ON pictures . * TO 'admin'@'localhost'";
sudo mysql -e "FLUSH PRIVILEGES";
sudo mysql -e "create table pictures.pictures(\`id\` int,\`image\` varchar(255),\`category\` varchar(50));";
sudo mysql -e "create table pictures.flag(\`id\` varchar(50));";
sudo mysql -e "insert into pictures.pictures(\`id\`,\`image\`,\`category\`) values ('1','animals-1.jpg','animals');";
sudo mysql -e "insert into pictures.pictures(\`id\`,\`image\`,\`category\`) values ('2','animals-2.jpg','animals');";
sudo mysql -e "insert into pictures.pictures(\`id\`,\`image\`,\`category\`) values ('3','animals-3.jpg','animals');";
sudo mysql -e "insert into pictures.pictures(\`id\`,\`image\`,\`category\`) values ('4','animals-4.jpg','animals');";
sudo mysql -e "insert into pictures.pictures(\`id\`,\`image\`,\`category\`) values ('5','animals-5.jpg','animals');";
sudo mysql -e "insert into pictures.pictures(\`id\`,\`image\`,\`category\`) values ('6','animals-6.jpg','animals');";
sudo mysql -e "insert into pictures.pictures(\`id\`,\`image\`,\`category\`) values ('7','nature-1.jpg','nature');";
sudo mysql -e "insert into pictures.pictures(\`id\`,\`image\`,\`category\`) values ('8','nature-2.jpg','nature');";
sudo mysql -e "insert into pictures.pictures(\`id\`,\`image\`,\`category\`) values ('9','nature-3.jpg','nature');";
sudo mysql -e "insert into pictures.pictures(\`id\`,\`image\`,\`category\`) values ('10','art-3.jpg','art');";
sudo mysql -e "insert into pictures.pictures(\`id\`,\`image\`,\`category\`) values ('11','art-3.jpg','art');";
sudo mysql -e "insert into pictures.pictures(\`id\`,\`image\`,\`category\`) values ('12','art-3.jpg','art');";
```

# Set up a flag

```
sudo mysql -e "insert into pictures.flag(\`id\`) values ('SQL_Injection_is_y0ur_Friend');";
```
