# Another kind of news! (csrf-1-defense)

Download VM:
* Credentials: ```user/user```, ```root/123456```
* SSH disabled
* Debian 11, 4 GB disk


# Agenda

After we successfully helped Bob and Alice, the portal administrator contacted us and asked for help with fixing the vulnerability.



# Setup

*Requirements:*  **4 GB** of disk space for VM.

```bash

sudo apt-get update --allow-releaseinfo-change
sudo apt-get install -y curl default-jdk htop libgconf-2-4 libxi6 mariadb-server maven mc nginx php php-fpm php-mysql python python2.7 unzip wget xvfb
```


#### Chrome driver and selenium setup
```
wget https://dl.google.com/linux/direct/google-chrome-stable_current_amd64.deb
sudo apt install ./google-chrome-stable_current_amd64.deb
wget https://chromedriver.storage.googleapis.com/2.41/chromedriver_linux64.zip
unzip chromedriver_linux64.zip
sudo mv chromedriver /usr/bin/chromedriver
sudo chown root:root /usr/bin/chromedriver
sudo chmod +x /usr/bin/chromedriver
rm -f google-chrome-stable_current_amd64.deb
rm -f chromedriver_linux64.zip
```
	





#### Setup VSCode

```bash
wget https://github.com/cdr/code-server/releases/download/2.1698/code-server2.1698-vsc1.41.1-linux-x86_64.tar.gz -O code-server.tar.gz
sudo mkdir /opt/code-server
sudo tar -zxvf code-server.tar.gz -C /opt/code-server --strip 1
rm -f code-server.tar.gz
```

Set code-server service (```sudo nano -c /etc/systemd/system/vscode.service```)



```
[Unit]
Description=VSCode as Service
After=network.target

[Service]

#WorkingDirectory=/opt/code-server
WorkingDirectory=/home/dev/source/
Environment="PASSWORD=12345"
User=dev
Group=dev
ExecStart=/opt/code-server/code-server --host=0.0.0.0 --port=8081 --allow-http --auth=none /home/dev/source/

[Install]
WantedBy=multi-user.target

```

#### Setup VSCode user

You need to add the **dev** user and check that it has the /home/dev/ folder

```
sudo adduser dev
#set password 12345

sudo mkdir /home/dev/source
sudo chmod 777 -R /home/dev/source

```



#### Nginx configure

Change **/etc/nginx/sites-enabled/default** (php-fpm version may be different):
```
server {
        listen       80;
        root   /var/www/html/;
        autoindex on;
        index index.php;
        location / {
            try_files $uri $uri/ /index.php;
            location = /index.php {
                include snippets/fastcgi-php.conf;
                fastcgi_pass unix:/run/php/php7.3-fpm.sock;
                fastcgi_param  SCRIPT_FILENAME /var/www/html/$fastcgi_script_name;
            }
        }
        location ^~ /application/ {
                deny all;
        }
        location ^~ /system/ {
                deny all;
        }
        location ~ \.php$ {
            return 444;
        }
}

```


Reload nginx and VSCode
```
sudo systemctl start vscode
sudo systemctl enable vscode
sudo service nginx restart
#sudo systemctl restart nginx
```






#### Setup deploy scripts

Put **bot_deploy**,**bot_test** and **bot_reload** in **/root** folder. They can be found in root folder.

```bash
#better to switch to root user
# su -l or sudo su
####This sometimes requires to remove CLRF
sudo tr -d '\r' < /root/bot_deploy > /root/bot_deploy.sh
sudo tr -d '\r' < /root/bot_test > /root/bot_test.sh
sudo tr -d '\r' < /root/bot_reload > /root/bot_reload.sh


sudo rm -f /sbin/bot_deploy
sudo rm -f /sbin/bot_test
sudo rm -f /sbin/bot_reload

sudo mv /root/bot_deploy.sh /root/bot_deploy
sudo mv /root/bot_test.sh /root/bot_test
sudo mv /root/bot_reload.sh /root/bot_reload
####

sudo chmod +x /root/bot_deploy
sudo chmod +x /root/bot_test
sudo chmod +x /root/bot_reload


sudo ln -s /root/bot_deploy /sbin/bot_deploy
sudo ln -s /root/bot_test /sbin/bot_test
sudo ln -s /root/bot_reload /sbin/bot_reload
```



Make possible to run **/sbin/bot_test**,**/sbin/bot_reload**,**/sbin/bot_deploy** with sudo. (```sudo nano -c /etc/sudoers```)

```
ALL ALL=NOPASSWD: /sbin/bot_test,/sbin/bot_reload,/sbin/bot_deploy
```


#### Source code upload

Put **source** folder to **/root/**



#### Configure database
```bash
    sudo mysql -e "UPDATE mysql.user SET Password = PASSWORD('12345') WHERE User = 'root'"
    sudo mysql -e "DELETE FROM mysql.user WHERE User='';"
    sudo mysql -e "DELETE FROM mysql.user WHERE User='root' AND Host NOT IN ('localhost', '127.0.0.1', '::1');"
    sudo mysql -e "DROP DATABASE IF EXISTS test;"
    sudo mysql -e "create database blog";
    sudo mysql -e "CREATE USER 'admin'@'localhost' IDENTIFIED BY 'admin'";
    sudo mysql -e "GRANT ALL PRIVILEGES ON blog . * TO 'admin'@'localhost'";
    sudo mysql -e "FLUSH PRIVILEGES";
```


#### Fill database with data
```bash
	sudo mysql blog < /root/source/web/db.sql
	sudo rm -f /root/source/web/db.sql
```



#### Bot setup
There are several command-line options for the bot:
 - -l,--login 
 - -p,--password
 - -h,--host - if not set, bot will try to get IPV4 from metadata ```169.254.169.254/latest/meta-data/public-ipv4```. You can set your host if not used in the cloud. See sample below.
 - -s,--screenshot - if set, will make a screenshot. Good for debugging.



Put bot folder under **/root/source/bot**. 

Bot folder structure:
- /root/source/bot/src
- /root/source/bot/pom.xml


Build bot from source code:
```
cd /root/source/bot
mvn package
```



#### Configure VSCode
- VSCode will be accessible on port 8081, open **IP:8081**
- Install **VSCode Action Buttons** extension
- Configure actionButtons extension 

```
{
    "actionButtons": {
        "reloadButton": null,
        "loadNpmCommands": false,
        "commands": [
		
            {
                "name": "▶ Deploy",
                "singleInstance": true,
                "color": "black",
                "command": "sudo /sbin/bot_deploy",
            },
            {
                "name": "✅ Test your code",
                "singleInstance": true,
                "color": "black",
                "command": "sudo /sbin/bot_test",
            },
            {
                "name": "↻ Reload source code",
                "singleInstance": true,
                "color": "black",
                "command": "sudo /sbin/bot_reload",
            },


        ]
    },
    "workbench.startupEditor": "newUntitledFile"
}
```
Press reload action buttons at the left bottom. You should see now three new buttons.


#### Final steps
Press newly created buttons in next order to make things work.
1. Run reaload
2. Deploy
3. Test 
4. Run reaload
5. Deploy


## How to check that everything works ?
1. After you press all the buttons,  open the main page. You should see the working app on 80 port. 


## Solution
1. Set CSRF protection in /application/config/config.php
```
$config['csrf_protection'] = TRUE;
```
2. Exclude some urls to make things easier

```
$config['csrf_exclude_uris'] = array('auth','login');
```
3.Locate application/views/post.php
 
 
4. Change next code:
```
		<?php if($isliked) {?>
		
		<a class="button is-danger is-small" href="/dislike/<?php echo $post['id'];?>">Dislike</a>
		
		<?php } else { ?>
		
		
		<a class="button is-success is-small"  href="/like/<?php echo $post['id'];?>">Like</a>
		<?php } ?>
```

To: 
 
```
		<?php if($isliked) {?>
		
      <?php  echo form_open("/dislike/".$post['id']); ?>
		<a class="button is-danger is-small"  href="/dislike/<?php echo $post['id'];?>">Dislike</a>
    <?php echo form_close();?>
		
		<?php } else { ?>
		
		
      <?php  echo form_open("/like/".$post['id']); ?>
		<a class="button is-success is-small"  href="/like/<?php echo $post['id'];?>">Like</a>
    <?php echo form_close();?>
		<?php } ?>
		```