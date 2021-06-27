<?php
session_start();
$mysqli = new mysqli("localhost", "admin", "admin", "guestbook");

if ($mysqli->connect_errno)
{
    echo "Unable to connect " . $mysqli->connect_error;
    die();
}

if (isset($_POST['login']) &&isset($_POST['password']) )
{
	$login=$mysqli->real_escape_string($_POST['login']);
	$password=$mysqli->real_escape_string(md5($_POST['password']));
	$result = $mysqli->query("select * from users where login='".$login."' and password='".$password."'");
	if($result->num_rows>0)
	{
		$_SESSION["admin"]=TRUE;
		header('Location: /index.php');
		exit;
	}
}


if (!$result) echo mysqli_error($mysqli);


?>



<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="/bulma.min.css">

  </head>
<body>

   <section class="hero is-fullheight">
        <div class="hero-body">
            <div class="container has-text-centered">
                <div class="column is-4 is-offset-4">
				
											
				
				
                    <h3 class="title has-text-black">Sign-in</h3>

					
					
                    <hr class="login-hr">
                    <p class="subtitle has-text-black">Please login to proceed.</p>
                    <div class="box">
                        <form method="POST" action="/login.php">
					<div class="field">
                                <div class="control">
                                    <input class="input is-large" type="text" name="login" placeholder="Your login" autofocus="">
                                </div>
                            </div>

                            <div class="field">
                                <div class="control">
                                    <input class="input is-large" type="password" name="password" placeholder="Your Password">
                                </div>
                            </div>
							

							  </div>
                            <button class="button is-block is-success is-large is-fullwidth" name="submit" >Login <i class="fas fa-sign-in-alt"></i></button>
                        </form>

						
						
                    </div>

                </div>
            </div>
        </div>
    </section>
<footer class="footer">
	<div class="content has-text-centered">

	</div>
</footer>



</body>
</html>