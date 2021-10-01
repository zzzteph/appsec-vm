<?php

if(isset($nofitication))
{
	echo "<h1>".$notification."</h1>";
}
?>

<h1>Change password</h1>
<form action="/user/change/password" id="/edit" method="post" accept-charset="utf-8">
               
 <div class="form-group">
 <label for="password">Password</label>
 <input type="password" name="password" value="" class="form-control"  />
</div> 
<div class="form-group"><label for="cpassword">Confirm</label><input type="password" name="cpassword" value="" class="form-control"  />
</div> <div class="form-group">

</div> <div class="form-group"><input type="submit" value="Update" class="btn btn-default"  />
</div></form>

