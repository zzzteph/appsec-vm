<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>CloudSec</title>
    <link href="/css/bootstrap.min.css" rel="stylesheet">
  </head>

  <body>

    <nav class="navbar navbar-toggleable-md navbar-inverse bg-inverse mb-4">
      <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <a class="navbar-brand" href="/">CloudSec</a>
      <div class="collapse navbar-collapse" id="navbarCollapse">
        <ul class="navbar-nav mr-auto">
          <li class="nav-item active">
            <a class="nav-link" href="/">Home</a>
          </li>
		  
		  
		  
		  
        </ul>
        <ul class="nav navbar-nav navbar-right">
			
		<?php if($login==NULL){ ?>
			
		  <li class="nav-item active">
            <a class="nav-link" href="/login">Login</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="/registration">Registration</a>
          </li>
          <?php }else{ ?>
           <li class="nav-item active">
            <a class="nav-link" href="/user/<?php echo $id;?>">My page</a>
          </li>
		<?php if($id==1){?>
		           <li class="nav-item active">
            <a class="nav-link" href="/admin">Admin Page</a>
          </li>
		
		<?php }?>
		  
		   <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="dropdown01" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Settings</a>
            <div class="dropdown-menu" aria-labelledby="dropdown01">
              <a class="dropdown-item" href="/user/change/settings">Change info</a>
              <a class="dropdown-item" href="/user/change/password">Change password</a>
            </div>
          </li>
		  
		  
		  
		  
		   <li class="nav-item active">
            <a class="nav-link" href="/logout">Logout</a>
           </li>
          <?php }?>
          
          
		</ul>
      </div>
    </nav>
    <div class="container">
