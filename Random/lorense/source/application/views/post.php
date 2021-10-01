<?php

 echo form_open('/edit/'.$id);
?>

<div class="form-group">
<label for="file">Title</label>
	<input type="text" name="title" value="<?php echo $title;?>" class="form-control"  />
</div>
<div class="form-group">
<label for="file">Info</label>
	<textarea name="info" class="form-control"  /><?php echo $info;?></textarea>
</div>

<?php
$attributes = array ('class' => 'btn btn-success','value'=>"Update");
echo ' <div class="form-group">';
echo form_submit($attributes);
echo "</div>";

echo form_close();
?>