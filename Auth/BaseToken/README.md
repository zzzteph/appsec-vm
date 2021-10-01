
# BToken 

Download VM:
* Credentials: ```user/user```, ```root/123456```
* SSH disabled
* Debian 11, 2 GB disk

# Agenda

You need to check the self-password-rest service and find the answer to the question, is there a possible way to reset passwords not only for you but for other users?
*It's dangerous to go alone:*
https://gist.github.com/zzzteph/21c3829061c701f8f3cb326bfb288758

# Setup

*Requirements:*  **2 GB** of disk space for VM.

Put all files in folder /var/www/html/

```
sudo apt-get update --allow-releaseinfo-change
sudo apt-get install -y php-fpm nginx sqlite3 php-sqlite3 unzip
sudo chown www-data:www-data -R /var/www/html/
sudo chmod 755 -R /var/www/html/*

```

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

Reload nginx

```
sudo  systemctl restart nginx
 ```



## How to check that everything works ?

1. Open main page.
2. Enter john@appsec.study as username for password reset.
 

## Solution

Check the exploit.php code.

The problem is in ```$token=substr(Base32::encode(md5(date('Y-m-d-H').$user.$secret)),0,8);``` line. By default ```md5``` return a 32-character hexadecimal number of ```date('Y-m-d-H').$user.$secret``` string, not binary string.
Base32 encodes every 5 bits of input. Md5 returns a string of chars, and each of them has 8 bits of information, and each of them can have the value ```0123456789abcdef```. So there is a limited keyspace for possible tokens. 40 bit's of information = 5 * 8 ==> 5 * sizeof(char). We need to iterate only the first five chars with different values of ```0123456789abcdef```, cause they only influence the first eight chars of the Base32 string.

To fix the vulnerability md5 must result binary string
```$token=substr(Base32::encode(md5(date('Y-m-d-H').$user.$secret,TRUE)),0,8);```

