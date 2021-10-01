<?php
if(isset($error))
{
	echo '<div class="alert alert-danger" role="alert">'.$error.'</div>';
}
?>

<h4>New registration!</h4>
<?php
$attributes = array ('id' => 'register');
echo form_open('/registration', $attributes);
$attributes = array ('class' => 'form-control','name'=>'login','value'=>"");
echo ' <div class="form-group">';
echo  '<label for="login">Login</label>';
echo form_input($attributes);
echo "</div>";

$attributes = array ('class' => 'form-control','name'=>'password','value'=>"");
echo ' <div class="form-group">';
echo  '<label for="password">Password</label>';
echo form_password($attributes);
echo "</div>";
$attributes = array ('class' => 'form-control','name'=>'cpassword','value'=>"");
echo ' <div class="form-group">';
echo  '<label for="cpassword">Confirm password:</label>';
echo form_password($attributes);
echo "</div>";

$attributes = array ('class' => 'btn btn-default','value'=>"Register");
echo ' <div class="form-group">';
echo form_submit($attributes);
echo "</div>";

echo form_close();
?>

