<?php
if(isset($error))
{
	echo '<div class="alert alert-danger" role="alert">'.$error.'</div>';
}
?>
<?php
$attributes = array ('id' => 'loginForm');
echo form_open('/login', $attributes);
?>                           
	<div class="form-group">
		<label for="login">Login</label>
		<input type="text" name="login" id="login"  value="<?php echo htmlspecialchars($login);?>" class="form-control"  />
	</div>
	<div class="form-group">
		<label for="password">Password</label>
		<input type="password" name="password"  id="password"  value="<?php echo htmlspecialchars($password);?>" class="form-control"  />
	</div>
	<div class="form-group">
		<input type="submit" value="Login" name="submit" id="submit" class="btn btn-default"  />
	</div>
<?php 
echo form_close();?>

