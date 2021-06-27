<?php

$mysqli = new mysqli("localhost", "admin", "admin", "contactbook");

if ($mysqli->connect_errno)
{
    echo "Unable to connect " . $mysqli->connect_error;
    die();
}

if (isset($_POST['search']) && strlen($_POST['search'])>3)
{
	$search=$mysqli->real_escape_string(trim($_POST['search']));
    $query = "SELECT * FROM employees where (`name` like '%".$search."%' or `surname` like '%".$search."%')";
	
	if(isset($_POST['department']))
	{
		
		if(count($_POST['department'])>0)
		{
			$where=" AND `department` in (";
			foreach($_POST['department'] as $dep)
			{
				$where.="'".$dep."',";
			}
			$where=substr($where, 0, -1);
			$where.=")";
			$query.=$where;
		}
	}
}
else
{
    $query = "SELECT * FROM employees AS t1 JOIN (SELECT id FROM employees ORDER BY RAND() LIMIT 10) as t2 ON t1.id=t2.id";
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
  <body>
  

  
  
  <section class="section">
    <div class="container">
      <h1 class="title">
			<a href="/">Employee contact book </a>
      </h1>
	  <div class="box">
	  <form method="POST" action="/">
		<div class="field has-addons">
		  <div class="control is-expanded">
			<input class="input" type="text" name="search" placeholder="Find contact">
		  </div>
		  <div class="control">
			<button class="button is-info">
			  Search
			</button>
		  </div>
		</div>
		 <div class="control">
		<label class="checkbox">
  <input type="checkbox" name="department[]" value="Development">
  Development
</label>
</div>
<div class="control">
<label class="checkbox">
  <input type="checkbox" name="department[]" value="Network">
  Network
</label>
</div>
<div class="control">
<label class="checkbox">
  <input type="checkbox" name="department[]" value="Support">
  Support
</label>
</div>
<div class="control">
<label class="checkbox">
  <input type="checkbox" name="department[]" value="Telephony">
  Telephony
</label>
</div>		


<div class="control">
<label class="checkbox">
  <input type="checkbox" name="department[]" value="Sales">
  Sales
</label>
</div>	
		
		</form>
		
		</div>
		<?php
		
		$inRow=0;
		
while ($row = $result->fetch_assoc())
{
?>


<?php if($inRow++%4==0) { ?>
	
	<div class="columns">
	
	
<?php }
?>
<div class="column">
	<div class="card">
	  <div class="card-content">
		<div class="media">
		  <div class="media-left">
			<figure class="image is-48x48">
			  <img src="/pictures/96x96.png" alt="Placeholder image">
			</figure>
		  </div>
		  <div class="media-content">
			<p class="title is-4"><?php echo $row['name']." ".$row['surname'];?></p>
			<p class="subtitle is-6"><?php echo $row['birth'];?></p>
		  </div>
		</div>

		<div class="content">
		  <a href="#"><?php echo $row['department'];?></a> 
		</div>
	  </div>
	</div>
</div>
<?php if($inRow%4==0) { ?>
	
	</div>
	
	
<?php }?>		
		
		<?php
}

if($inRow%4!=0)
{?>
	</div>
<?php }
?>
		
		
    </div>
  </section>

  
  
  </body>
</html>