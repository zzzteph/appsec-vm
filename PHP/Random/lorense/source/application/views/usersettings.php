<?php

if(isset($nofitication))
{
	echo "<h1>".$notification."</h1>";
}
?>

<h1>Settings</h1>
<?php

 echo form_open_multipart('/user/change/settings');
?>

<div class="form-group">
<label for="file">Name</label>
	<input type="text" name="name" value="<?php echo htmlentities($user['name']);?>" class="form-control"  />
</div>

<div class="form-group">
<label for="file">Surname</label>
	<input type="text" name="surname" value="<?php echo htmlentities($user['surname']);?>" class="form-control"  />
</div>
<div class="form-group">
<label for="file">Info</label>
	<textarea name="info" class="form-control"  /><?php echo htmlentities($user['info']);?></textarea>
</div>



 <div class="form-group">
 <img src="/uploads/<?php echo $user['avatar'];?>">
 </div>


  <div class="form-group">
    <label for="file">Avatar image</label>
    <input type="file" class="form-control-file" id="file" name="file" aria-describedby="fileHelp">
    <small id="fileHelp" class="form-text text-muted">Support only jpeg,jpg,png images</small>
  </div>

<?php
$attributes = array ('class' => 'btn btn-success','value'=>"Change");
echo ' <div class="form-group">';
echo form_submit($attributes);
echo "</div>";

echo form_close();
?>
