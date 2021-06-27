<?php
require_once('./settings.php');
if(!isset($_SESSION['user_id']))
{
	header('Location: /index.php');
	exit;
}
$user_id=$_SESSION['user_id'];

if (isset($_GET['id']))
{
$post = $client->secrets->posts->findOne( [			'_id' => new MongoDB\BSON\ObjectId($_GET['id']) ]);

}
else
{
	die("Unable to find paste!");
}


if (isset($_POST['paste']) && strlen($_POST['paste'])>3 && isset($_POST['title']) && strlen($_POST['title'])>3 && strlen($_POST['title'])<30)
{
	$filterOption = ["_id" => new \MongoDB\BSON\ObjectID($_GET['id'])];
	$updateOption = ["title" => (string) $_POST['title'],'content' => (string) $_POST['paste']];
	
	

	 $client->secrets->posts->updateOne(
			$filterOption, 
			['$set' => $updateOption], 
		);

$post = $client->secrets->posts->findOne( [			'_id' => new MongoDB\BSON\ObjectId($_GET['id'])] );

}


if($post==null)die("Unable to find paste!");
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

<h1 class="title">Edit your paste</h1>
<form method="POST" action="/edit.php?id=<?php echo $post->{'_id'};?>">
  <div class="media-content">

  <div class="field">
  <label class="label">Name</label>
  <div class="control">
    <input class="input" type="text" name="title" placeholder="Title input" value="<?php echo $post->{'title'}; ?>">
  </div>
</div>
  
  
    <div class="field is-fullwidth">
      <p class="control is-fullwidth">
        <textarea class="textarea is-fullwidth" name="paste" placeholder="Add a comment."><?php echo $post->{'content'}; ?></textarea>
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