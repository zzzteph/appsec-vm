
<?php
$attributes = array ('id' => '/edit');
echo form_open('/user/changepassword/', $attributes);
$attributes = array ('class' => 'form-control','name'=>'password','value'=>'');
echo ' <div class="form-group">';
echo  '<label for="name">New Password</label>';
echo form_input($attributes);
echo "</div>";

$attributes = array ('class' => 'form-control','name'=>'cpassword','value'=>'');
echo ' <div class="form-group">';
echo  '<label for="surname">Confirm</label>';
echo form_input($attributes);
echo "</div>";


$attributes = array ('class' => 'btn btn-default','value'=>"Update");
echo ' <div class="form-group">';
echo form_submit($attributes);
echo "</div>";

echo form_close();
?>

