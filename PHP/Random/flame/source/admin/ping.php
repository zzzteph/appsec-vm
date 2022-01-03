<?php

$cmd="";
if(isset($_POST['cmd']))
	$cmd=$_POST['cmd'];

$cmd= preg_replace('/\s+/', '', $cmd);
$command="ping -c 1 ".escapeshellarg($cmd);
$debug="";
if(isset($_POST['cmd']))
{
	
	$debug=shell_exec($command);
}

?>


<?php

include('include.php');

?>
  
  
  <section class="section">
    <div class="container">
      <h1 class="title">
      Ping
      </h1>


		<form method="POST" action="/admin/ping.php">
		
		
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