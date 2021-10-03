<?php

require_once('./settings.php');


if (isset($_POST['login']) &&isset($_POST['password']) )
{
	$user = $client->secrets->users->findOne( [
			'login' => (string) $_POST['login']
	] );
	

	if(!is_null($user))
	{
			if($user->password==md5((string)$_POST['password']))
			{
				$_SESSION["user_id"]=$user->{_id};
				session_regenerate_id(true);
				header('Location: /index.php');
				exit;
			}
			
			
	}
	else
	{
		//check if we can register user
		
		$insertedUser = $client->secrets->users->insertOne([
			'login' => (string) $_POST['login'],
			'password' => md5((string) $_POST['password'])
		]);

			$_SESSION["user_id"]=$insertedUser->getInsertedId();
			session_regenerate_id(true);
			header('Location: /index.php');
			exit;

	}
}
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
				
											
				
				
                    <h3 class="title has-text-black">Sign-in/Sign-up</h3>

					
					
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