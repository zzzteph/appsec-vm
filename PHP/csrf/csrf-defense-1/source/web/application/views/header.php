<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <title>CyberBlog</title>
      <link rel="stylesheet" href="/assets/css/bulma.min.css">




   </head>
   <body>
<nav class="navbar">
    <div class="container">
        <div class="navbar-brand">
            <span class="navbar-burger burger" data-target="navbarMenu">
			<span></span>
            <span></span>
            <span></span>
            </span>
        </div>
        <div id="navbarMenu" class="navbar-menu">
            <div class="navbar-end">
                <a class="navbar-item" href="/">Home</a>
				<?php if(isset($login)) {?>
				
				 <a class="navbar-item has-text-danger" href="/logout">Exit</a>
				
				<?php } else { ?>
                <a class="navbar-item" href="/auth">Sign-in</a>
				<?php } ?>
            </div>
        </div>
    </div>
</nav>
