<?php
$mysqli = new mysqli("localhost", "admin", "admin", "pictures");

if ($mysqli->connect_errno)
{
    echo "Unable to connect " . $mysqli->connect_error;
    die();
}

if (isset($_POST['search']))
{
    $query = "SELECT * FROM pictures where category='" . $_POST['search'] . "'";
}
else
{
    $query = "SELECT * FROM pictures AS t1 JOIN (SELECT id FROM pictures ORDER BY RAND() LIMIT 1) as t2 ON t1.id=t2.id";
}
$result = $mysqli->query($query);
if (!$result) echo mysqli_error($mysqli);

?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title></title>
    <link rel="stylesheet" href="/bulma.min.css">
	    <style type="text/css" media="screen">
      body {
        display: flex;
        min-height: 100vh;
        flex-direction: column;
      }
 
      #wrapper {
        flex: 1;
      }
    </style>
	
	
  </head>
  <body class="has-background-black">
  

  
  
  <section class="section">
    <div class="container">
      <h1 class="title">
       Search for picture
      </h1>
	  <div class="box">
	  <form method="POST" action="/">
		<div class="field has-addons">
		  <div class="control is-expanded">
			<input class="input" type="text" name="search" placeholder="Find a picture">
		  </div>
		  <div class="control">
			<button class="button is-info">
			  Search
			</button>
		  </div>
		</div>
		</form>
		
		</div>
		<?php
while ($row = $result->fetch_assoc())
{
?>
		
		<div class="card">
			  <div class="card-image">
				<figure class="image">
				  <img src="/pictures/<?php echo $row['image']; ?>">
				</figure>
			  </div>
			  <div class="card-content">


				<div class="content">
				  Lorem ipsum dolor sit amet, consectetur adipiscing elit.
				  Phasellus nec iaculis mauris.
				  <a href="#"><?php echo $row['category']; ?></a>
				  <br>
				
				</div>
			  </div>
			</div>
		
		
		<?php
}
?>
		
		
    </div>
  </section>

  
  
  </body>
</html>