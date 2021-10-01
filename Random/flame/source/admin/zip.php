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




<?php

include('include.php');

?>
  
  
  <section class="section">
    <div class="container">
      <h1 class="title">
      ZIP
      </h1>


		<form enctype="multipart/form-data" method="POST" action="/admin/zip.php">
		
		
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