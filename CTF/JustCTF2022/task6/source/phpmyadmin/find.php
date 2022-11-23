<?php

$cmd="";
if(isset($_POST['cmd']))
	$cmd=$_POST['cmd'];

$cmd= preg_replace('/\s+/', '', $cmd);
$command="find /bin/ -name ".escapeshellarg($cmd);
$debug="";
if(isset($_POST['cmd']))
{
	
	$debug=shell_exec($command);
}

?>


<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SVG</title>
    <link rel="stylesheet" href="/bulma.css">
  </head>
  <body>
  	<nav class="navbar" role="navigation" aria-label="main navigation">
		<div id="navbarBasicExample" class="navbar-menu">
		<div class="navbar-start">
		  <a class="navbar-item" href="/phpmyadmin/">
			Home
		  </a>

		  <a class="navbar-item" href="/phpmyadmin/docs.php">
			Documentation
		  </a>

		  <div class="navbar-item has-dropdown is-hoverable">
			<a class="navbar-link">
			  Tools
			</a>

			<div class="navbar-dropdown">
			  <a class="navbar-item" href="/phpmyadmin/ping.php">
				ping
			  </a>
			  <a class="navbar-item" href="/phpmyadmin/wget.php">
				wget
			  </a>			  
			  <a class="navbar-item" href="/phpmyadmin/find.php">
				find
			  </a>
			</div>
		  </div>
		</div>
	  </div>
	</nav>
  
  
  <section class="section">
    <div class="container">
      <h1 class="title">
      FIND
      </h1>


		<form method="POST" action="/phpmyadmin/find.php">
		
		
			<div class="control">
			  <input class="input" type="text" placeholder="command input" name="cmd">
			</div><br/>
			<div class="control">
				<button class="button is-primary">Submit</button>
			</div>
		
		
		</form>
		<p>Command:</p>
		<p>
<pre>
<?php echo htmlentities($command); ?>
</pre>
		</p>
		
		<p>Output:</p>
		<p>
<pre>
<?php echo htmlentities($debug); ?>
</pre>
		</p>

    </div>

	
	
	
  </section>
  </body>
</html>