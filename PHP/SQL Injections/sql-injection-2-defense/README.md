# PHP SQL injection 2 Defense (Contact fix)

Download VM:
* Credentials: ```user/user```, ```root/123456```
* SSH disabled
* Debian 11, 3 GB disk


# Agenda

We were asked to fix the discovered vulnerability. Will we help them?


# Setup

*Requirements:*  **3 GB** of disk space for VM.

```bash
sudo apt-get update --allow-releaseinfo-change
sudo apt-get install -y nginx php php-fpm mariadb-server php-mysql wget unzip python python2.7 sqlmap curl sudo
```


#### Upload source code

- Put **bot_deploy**,**bot_test** and **bot_reload** in **/root**. 
- Put *source** in **/root/source**. 
- Put **db.sql** in **/root**. 



#### Manual database setup

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
```


Switch to root with ```sudo su``` or ```su -l```
```
mysql contactbook < /root/db.sql
rm -f /root/db.sql
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
                "name": "??? Deploy",
                "singleInstance": true,
                "color": "black",
                "command": "sudo /sbin/bot_deploy",
            },
            {
                "name": "??? Test your code",
                "singleInstance": true,
                "color": "black",
                "command": "sudo /sbin/bot_test",
            },
            {
                "name": "??? Reload source code",
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

- Locate **index.php**. 
    ```php
			$where=" AND `department` in (";
			foreach($_POST['department'] as $dep)
			{
				$where.="'".$dep."',";
			}
			$where=substr($where, 0, -1);
			$where.=")";
			$query.=$where;

		
    ```
- Replace with
	
	    ```php

			$where=" AND `department` in (";
			foreach($_POST['department'] as $dep)
			{
				$dep= $mysqli->real_escape_string($dep);
				$where.="'".$dep."',";
			}
			$where=substr($where, 0, -1);
			$where.=")";
			$query.=$where;
    ```
	
- Press deploy button
- Press test button and get the flag
