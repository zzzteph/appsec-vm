<?php
session_start();
if(!isset($_SESSION['user_id']))
{
	header('Location: /index.php');
	exit;
}
$user_id=$_SESSION['user_id'];
$mysqli = new mysqli("localhost", "admin", "admin", "secrets");

if (isset($_GET['id']))
{
	$id=$mysqli->real_escape_string($_GET['id']);
	$result = $mysqli->query("select * from posts where id='$id'");

}
else
{
	die("Unable to find paste!");
}


if (isset($_POST['paste']) && strlen($_POST['paste'])>3 && isset($_POST['title']) && strlen($_POST['title'])>3 && strlen($_POST['title'])<30)
{
	$paste=$mysqli->real_escape_string($_POST['paste']);
	$title=$mysqli->real_escape_string($_POST['title']);
	$mysqli->query("update posts set `content`='".$paste."',`title`='".$title."' where id='$id'");
		$result = $mysqli->query("select * from posts where id='$id'");
}




if (!$result) {echo mysqli_error($mysqli);die();}
if($result->num_rows==0)die("Unable to find paste!");
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
        Secret
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
<h1 class="title">Edit your paste</h1>
<form method="POST" action="/edit.php?id=<?php echo $id;?>">
  <div class="media-content">

  <div class="field">
  <label class="label">Name</label>
  <div class="control">
    <input class="input" type="text" name="title" placeholder="Title input" value="<?php echo $row['title']; ?>">
  </div>
</div>
  
  
    <div class="field is-fullwidth">
      <p class="control is-fullwidth">
        <textarea class="textarea is-fullwidth" name="paste" placeholder="Add a comment."><?php echo $row['content']; ?></textarea>
      </p>
    </div>
    <nav class="level">
      <div class="level-left">
        <div class="level-item">
          <button class="button is-success" name="submit">Generate paste</a>
        </div>
      </div>
    </nav>
  </div>
  </form>
 <?php }?>

    </div>

    </section>
	



</body>
</html>