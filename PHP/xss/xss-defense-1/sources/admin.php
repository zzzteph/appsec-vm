<?php


session_start();
if($_SESSION['admin'] == TRUE)
{
	?>
	Someday I will finish this page. Need to change the name of my blog to <b> Super_MBlog</b>
	
	
	
	<?php 
} else { ?>




ACCESS DENIED!



<?php } ?>