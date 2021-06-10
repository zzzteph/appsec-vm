<?php
session_start();
$mysqli = new mysqli("localhost", "admin", "admin", "guestbook");

if ($mysqli->connect_errno)
{
    echo "Unable to connect " . $mysqli->connect_error;
    die();
}

if (isset($_POST['comment']) && strlen($_POST['comment'])>3)
{
	$comment=$mysqli->real_escape_string($_POST['comment']);
	$mysqli->query("insert into posts(`content`) values('".$comment."')");
}

$result = $mysqli->query("select * from posts order by id desc limit 3");
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
        Home
      </a>
      <a class="navbar-item"  href="/admin.php">
        Admin
      </a>
    </div>

    <div class="navbar-end">
      <div class="navbar-item">
		<div class="buttons">
          <a class="button is-success is-size-5" href="/login.php">
            Log in
          </a>
        </div>
 
      </div>
	  

	  
	  
	  
    </div>
  </div>
</nav>
		</div>

    </section>
		<section class="section">
<div class="container">
	
	
	
	<section class="section">
<div class="container">

<?php 
if($_SESSION['admin'] == TRUE)
{
	?>
	<h1 class="title">Hello Michael!</h1>
	
	
	
	<?php 
}
?>
<h1 class="title">
 Hello! My name is Michael and this is my personal guestbook.</h1>
<h2 class="subtitle"> You can write me a message and I'll try to read it.</h2>
 
    </div>

    </section>
 
 <?php
 
 while ($row = $result->fetch_assoc())
{
	
	?>
   <article class="media box">
  <div class="media-content">
    <div class="content">
<p>
<?php echo $row['content']; ?>
      </p>
    </div>

  </div>

</article>
<?php } ?>
    </div>

    </section>
	
	
		<section class="section">
<div class="container">
<form method="POST" action="/">
  <div class="media-content">
    <div class="field is-fullwidth">
      <p class="control is-fullwidth">
        <textarea class="textarea is-fullwidth" name="comment" placeholder="Add a comment..."></textarea>
      </p>
    </div>
    <nav class="level">
      <div class="level-left">
        <div class="level-item">
          <button class="button is-success" name="submit">Add comment</a>
        </div>
      </div>
    </nav>
  </div>
  </form>


    </div>

    </section>
	
	
	
<footer class="footer">
	<div class="content has-text-centered">

	</div>
</footer>



</body>
</html>