<?php 


foreach($posts as $post)
{
	?>
	
	<div class="card">
  <div class="card-block">
    <h4 class="card-title"><?php echo htmlentities($post['title']);?></h4>
    <p class="card-text"><?php echo $post['info'];?></p>
    <a href="/edit/<?php echo $post['id'];?>" class="card-link">edit</a>
	<a href="/delete/<?php echo $post['id'];?>" class="card-link">delete</a>
  </div>
</div>
	
	
	
	<?php
}
?>





<?php

 echo form_open('/');
?>

<div class="form-group">
<label for="file">Title</label>
	<input type="text" name="title" value="" class="form-control"  />
</div>
<div class="form-group">
<label for="file">Info</label>
	<textarea name="info" class="form-control"  /></textarea>
</div>

<?php
$attributes = array ('class' => 'btn btn-success','value'=>"Create");
echo ' <div class="form-group">';
echo form_submit($attributes);
echo "</div>";

echo form_close();
?>


