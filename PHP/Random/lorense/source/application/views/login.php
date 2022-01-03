<?php
if(isset($error))
{
	echo '<div class="alert alert-danger" role="alert">'.$error.'</div>';
}
?>
<form action="/login" id="register" method="post" accept-charset="utf-8">                                    
	<div class="form-group">
		<label for="login">Login</label>
		<input type="text" name="login" value="<?php echo htmlspecialchars($login);?>" class="form-control"  />
	</div>
	<div class="form-group">
		<label for="password">Password</label>
		<input type="password" name="passwd" value="<?php echo $password;?>" class="form-control"  />
	</div>
	<div class="form-group">
<input type="submit" value="Login" name="Log_On" id="Log_On" class="btn btn-default"  />
	</div>
</form>
