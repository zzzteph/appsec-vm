<?php
session_start();
$mysqli = new mysqli("localhost", "admin", "admin", "secrets");
if ($mysqli->connect_errno)
{
    echo "Unable to connect " . $mysqli->connect_error;
    die();
}

if (isset($_POST['paste']) && strlen($_POST['paste'])>3 && isset($_POST['title']) && strlen($_POST['title'])>3 && strlen($_POST['title'])<30)
{
	$paste=$mysqli->real_escape_string($_POST['paste']);
	$title=$mysqli->real_escape_string($_POST['title']);
	$mysqli->query("insert into posts(`content`,`title`,`user_id`) values('".$paste."','".$title."','0')");
}

$result = $mysqli->query("select id,title from posts where user_id=0 order by id desc limit 5");
if (!$result) echo mysqli_error($mysqli);

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
<div class="columns">
	<div class="column">
<h1 class="title">Secret Bin </h1>
<h2 class="subtitle"> You can paste your secrets through our opensource online pastebin. Data is encrypted/decrypted in the browser using 256 bits AES!! Stay safe, stay private!</h2>
 <p>You can share public pastes with your collegues.</p>
 <p>if you register you can get access to our secure storage.</p>
 
 </div>
 <div class="column">
 <strong> Latest public pastes:</strong>
 
  <?php while ($row = $result->fetch_assoc()){		?>

<p><a href="/view.php?id=<?php echo $row['id']; ?>"><?php echo $row['title']; ?></a></p>


<?php } ?>
 
 
 
 </div>
    </div>

    </section>

	
		<section class="section">
<div class="container">
<form method="POST" action="/">
  <div class="media-content">
  
  <div class="field">
  <label class="label">Name</label>
  <div class="control">
    <input class="input" type="text" name="title" placeholder="Title input">
  </div>
</div>
  
  
    <div class="field is-fullwidth">
      <p class="control is-fullwidth">
        <textarea class="textarea is-fullwidth" name="paste" placeholder="Add a comment."></textarea>
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


    </div>

    </section>
	
	
	


</body>
</html>