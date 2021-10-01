<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link href="/css/bootstrap.min.css" rel="stylesheet">
  
  </head>

  <body>

    <nav class="navbar navbar-toggleable-md">
      <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
     
      <div class="collapse navbar-collapse" id="navbarCollapse">
        <ul class="navbar-nav mr-auto">
		  <li class="nav-item active">
            <a class="nav-link text-success" href="/" >HOME</a>
          </li>

		<?php if($login==NULL){ ?>
			
		  <li class="nav-item active">
            <a class="nav-link text-success" href="/login" >Sign in</a>
          </li>
          <li class="nav-item">
            <a class="nav-link text-success" href="/registration">Sign up</a>
          </li>
          <?php }else{ ?>
		  
		            <li class="nav-item">
            <a class="nav-link text-success" href="/messages">Messages</a>
          </li>
	
		  
           <li class="nav-item active">
            <a class="nav-link text-success" href="/user/<?php echo $id;?>">My page</a>
          </li>
		  <li class="nav-item active">
            <a class="nav-link text-success" href="/user/changepassword">Password change</a>
          </li>

		  
		  
		   <li class="nav-item active">
            <a class="nav-link text-success" href="/logout">Logout</a>
           </li>
		   <?php if($id==1) {?>
		   
		    <li class="nav-item active">
            <a class="nav-link text-success" href="/SuperSecret">Flag</a>
           </li>
		   <?php } ?>
		   
		   
          <?php }?>
          
          
		</ul>
      </div>
    </nav>
    <div class="container">
