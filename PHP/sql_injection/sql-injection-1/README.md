

# Setup
```bash
sudo apt-get update
sudo apt-get install nginx mariadb-server php-fpm php-mysql
mysql -e "UPDATE mysql.user SET Password = PASSWORD('12345') WHERE User = 'root'"
mysql -e "DELETE FROM mysql.user WHERE User='';"
mysql -e "DELETE FROM mysql.user WHERE User='root' AND Host NOT IN ('localhost', '127.0.0.1', '::1');"
mysql -e "DROP DATABASE IF EXISTS test;"
mysql -e "DELETE FROM mysql.db WHERE Db='test' OR Db='test\\_%';"
mysql -e "create database pictures";
mysql -e "CREATE USER 'admin'@'localhost' IDENTIFIED BY 'admin'";
mysql -e "GRANT ALL PRIVILEGES ON pictures . * TO 'admin'@'localhost'";
mysql -e "FLUSH PRIVILEGES";
mysql -e "create table pictures.pictures(\`id\` int,\`image\` varchar(255),\`category\` varchar(50));";
mysql -e "create table pictures.flag(\`id\` varchar(50));";
mysql -e "insert into pictures.pictures(\`id\`,\`image\`,\`category\`) values ('1',''animals-1.jpg','animals');";
mysql -e "insert into pictures.pictures(\`id\`,\`image\`,\`category\`) values ('2','animals-2.jpg','animals');";
mysql -e "insert into pictures.pictures(\`id\`,\`image\`,\`category\`) values ('3','animals-3.jpg','animals');";
mysql -e "insert into pictures.pictures(\`id\`,\`image\`,\`category\`) values ('4','animals-4.jpg','animals');";
mysql -e "insert into pictures.pictures(\`id\`,\`image\`,\`category\`) values ('5','animals-5.jpg','animals');";
mysql -e "insert into pictures.pictures(\`id\`,\`image\`,\`category\`) values ('6','animals-6.jpg','animals');";
mysql -e "insert into pictures.pictures(\`id\`,\`image\`,\`category\`) values ('7','nature-1.jpg','nature');";
mysql -e "insert into pictures.pictures(\`id\`,\`image\`,\`category\`) values ('8','nature-2.jpg','nature');";
mysql -e "insert into pictures.pictures(\`id\`,\`image\`,\`category\`) values ('9','nature-3.jpg','nature');";
mysql -e "insert into pictures.pictures(\`id\`,\`image\`,\`category\`) values ('10','art-3.jpg','art');";
mysql -e "insert into pictures.pictures(\`id\`,\`image\`,\`category\`) values ('11','art-3.jpg','art');";
mysql -e "insert into pictures.pictures(\`id\`,\`image\`,\`category\`) values ('12','art-3.jpg','art');";
```

# Set up a flag

```
mysql -e "insert into pictures.flag(\`id\`) values ('YOUR_FLAG');";
```
