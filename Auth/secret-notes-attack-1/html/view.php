<?php
session_start();
$mysqli = new mysqli("localhost", "admin", "admin", "secrets");


if (isset($_GET['id']))
{
	$id=$mysqli->real_escape_string($_GET['id']);
	if(!isset($_SESSION['user_id']))
		$result = $mysqli->query("select * from posts where id='$id' and user_id=0");
	else
	{
		$user_id=$_SESSION['user_id'];
		$result = $mysqli->query("select * from posts where id='$id' and (user_id=0 or user_id=$user_id)");
	}
}
else
{
	die("Unable to find paste!");
}
if (!$result) {echo mysqli_error($mysqli);die();}
if($result->num_rows==0)die("Access denied!");
?>


<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="/bulma.min.css">
  </head>
<body>

    <section class="section">
	
	 <div class="container is-size-5">
<nav class="navbar" role="navigation" aria-label="main navigation">
  <div class="navbar-brand">


    <a role="button" class="navbar-burger" aria-label="menu" aria-expanded="false" data-target="navbarBasicExample">
      <span aria-hidden="true"></span>
      <span aria-hidden="true"></span>
      <span aria-hidden="true"></span>
    </a>
  </div>

  <div id="navbarBasicExample" class="navbar-menu">
    <div class="navbar-start">
      <a class="navbar-item" href="/">
        SecretsBin
      </a>
	  <?php if(isset($_SESSION['user_id'])){?>
      <a class="navbar-item"  href="/secret.php">
        Secrets
      </a>
	  <?php }?>
    </div>

    <div class="navbar-end">
      <div class="navbar-item">
		<div class="buttons">
		  <?php if(!isset($_SESSION['user_id'])){?>
		
          <a class="button is-success is-size-5" href="/login.php">
            Log in
          </a>
		  <?php } else { ?>
		  
		    <a class="button is-danger is-size-5" href="/logout.php">
            Logout
          </a>
		  <?php } ?>
		  
		  
		  
        </div>
 
      </div>
	  

	  
	  
	  
    </div>
  </div>
</nav>
		</div>

    </section>

	
	
	
	<section class="section">
<div class="container">

  <?php while ($row = $result->fetch_assoc()){		?>
<h1 class="title"><?php echo htmlentities($row['title']); ?></h1>
<p><pre><?php echo htmlentities($row['content']); ?></pre></p>


<?php } ?>
 
 
 
 </div>


    </section>

	

	



</body>
</html>