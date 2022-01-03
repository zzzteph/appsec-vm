<p class="h1"><?php echo htmlspecialchars($login);?> 

<?php 
if($id!=$sid)
{?>

<small><a href="/write/<?php echo $id;?>">Write message </a></small>

<?php }?>

</p>

<h3> Whoami? </h3>

<?php echo $info;?>




