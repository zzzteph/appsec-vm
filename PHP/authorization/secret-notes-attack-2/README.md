


# Setup
```bash
sudo apt-get update
sudo apt-get install nginx php-fpm php-dev php-pear gnupg composer
sudo pecl install mongodb
wget -qO - https://www.mongodb.org/static/pgp/server-4.4.asc | sudo apt-key add -
echo "deb http://repo.mongodb.org/apt/debian buster/mongodb-org/4.4 main" | sudo tee /etc/apt/sources.list.d/mongodb-org-4.4.list
sudo apt-get install -y mongodb-org
sudo systemctl start mongod
sudo systemctl enable mongod

echo "extension=mongodb.so" >> `php --ini | grep "Loaded Configuration" | sed -e "s|.*:\s*||"`
composer require mongodb/mongodb
chmod 777 -R /var/www/html
```


Put extension=mongodb.so to php.ini in php-fpm


There is lack of authorization in posts edit. 
1. Register new user
2. Create new secret paste
3. Use mongo predict to find admin post

Password - 4j9X3hxG3w9feSk9