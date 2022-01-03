<?php



$path="";

if(isset($_GET['path']))
	$path=$_GET['path'];


if(isset($_GET['action'])=="view")
{
	
	header('Content-Type: text/plain');
	$path=realpath (getcwd()."/files/".$path);
	if(realpath(dirname(__FILE__))."/index.php"==$path)
	{
		echo "PHP FILE read disabled";
	        die();
	}
	if($path==="/etc/passwd")
	{
		echo "S3c-r3-t_backdoor".PHP_EOL;
	}
	echo file_get_contents($path);
	die();
}

$path=str_replace("..","",$path);
$path=str_replace("//","/",$path);

$dir =  realpath (getcwd()."/files/".$path);

$file=$dir;



?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>SFE</title>
    <link rel="stylesheet" href="/bulma.min.css">
</head>

<body> 

    <section class="articles">
        <div class="container">
            <div class="card">
                <div class="card-content">
					<div class="content">
							<div class="table-container">
							<table class="table">
								<?php
								
								
								
									foreach (scandir($dir) as $f) 
									{
									  if ($f !== '.' and $f !== '..')
									  {
										  
										  echo "<tr>";
										  echo "<td>";
										  if(is_dir($dir.'/'.$f))
										  {
												echo '<a href="/?path='.$path."/".$f.'">'.$f.'</a>';
										  }
										  else
										  {
											  echo $f;
										  }
										  echo "</td>";
										  echo "<td>";
										 if(!is_dir($dir.'/'.$f))
										    echo '<a href="/?action=view&path='.$path."/".$f.'">view</a>';
										  
										  echo "</td>";											 
										  
										  echo "</tr>";
										  
										  
									  }
									  
									  
									   if ( $f === '..')
									  {
										  

										  echo "<tr>";
										  echo "<td>";
											echo '<a href="/?path='.dirname($path).'">'.$f.'</a>';
										  echo "</td>";
										  echo "<td>";
										  echo "</td>";											 
										 
										  echo "</tr>";
										  
										  
									  }

									  
									}
								
								?>
								
			
							</table>
							</div>	
                    </div>
                </div>
            </div>
        </div>
    </section>

    <br />
</body>

</html>
