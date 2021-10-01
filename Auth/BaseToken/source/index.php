<?php
include ("Base32.php");
include ("config.php");
$link = new PDO('sqlite:./users.db');

if (isset($_GET['send_token']))
{
    if (isset($_POST['email']))
    {
        $email = $_POST['email'];
        $sth = $link->prepare("select * from users where email=:email");
        $sth->bindParam(':email', $email, PDO::PARAM_STR);
        $sth->execute();
        $user = false;

        foreach ($sth->fetchAll() as $entry)
        {
            $user = $entry['email'];
        }

        if ($user != false)
        {
            $token = substr(Base32::encode(md5(date('Y-m-d-H') . $user . $secret)) , 0, 8);
            send_email($user, $token);

            header('Location: /?reset&token_send');
        }
        else
        {
            header('Location: /?user_not_found');
        }

    }

}
if (isset($_GET['reset']))
{
    if (isset($_POST['email']) && isset($_POST['token']) && isset($_POST['password']))
    {
        $email = $_POST['email'];
        $sth = $link->prepare("select * from users where email=:email");
        $sth->bindParam(':email', $email, PDO::PARAM_STR);
        $sth->execute();
        $user = false;

        foreach ($sth->fetchAll() as $entry)
        {
            $user = $entry['email'];
        }
        if ($user != false)
        {
            $token = substr(Base32::encode(md5(date('Y-m-d-H') . $user . $secret)) , 0, 8);
            if ($token === $_POST['token'])
            {
                $change_success = change_ldap_password($user, $_POST['password']);

            }
            else
            {
                header('Location: /?reset&wrong_token');
            }

        }
        else
        {
            header('Location: /?reset&user_not_found');
        }

    }
    else if (!empty($_POST))
    {
        header('Location: /?reset&not_all_params');
    }

}

?>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SPRS</title>
    <link rel="stylesheet" href="/bulma.min.css" />
    <link rel="stylesheet" type="text/css" href="/login.css">
</head>

<body>
    <section class="hero is-success is-fullheight">
        <div class="hero-body">
            <div class="container has-text-centered">
                <div class="column is-4 is-offset-4">
                    <h3 class="title has-text-black">Self Password Reset Service</h3>
                    <hr class="login-hr">
                  
					
					<?php if (!isset($_GET['reset']))
{ ?>
					<p class="subtitle has-text-black">Enter your corporate email to get reset token</p>
					<?php if (isset($_GET['user_not_found']))
    { ?>
					
					<article class="message is-danger">
  <div class="message-header">
    <p>Error</p>

  </div>
  <div class="message-body">
 User not found  </div>
</article>
					
					
					<?php
    } ?>
                    <div class="box">
                        <form method="POST" action="/?send_token">
                            <div class="field">
                                <div class="control">
                                    <input class="input is-large" type="email" name="email" placeholder="Your Email" autofocus="">
                                </div>
                            </div>

                            <button class="button is-block is-info is-large is-fullwidth">Send </button>
                        </form>
                    </div>
                    <p class="has-text-grey">
                 
                        <a href="/index.php?reset">Reset password</a> &nbsp;·&nbsp;
						<a href="/manual.php">Manual</a>
                    </p>
					
					
					<?php
}
else
{ ?>
					
					<?php if (isset($_GET['token_send']))
    { ?>
											
											<article class="message is-success">
						  <div class="message-header">
							<p>Token send</p>

						  </div>
						  <div class="message-body">
						Token was send, please check you mail box. </div>
						</article>
											
					
					<?php
    } ?>
					
					
										<?php if (isset($_GET['not_all_params']))
    { ?>
											
											<article class="message is-danger">
						  <div class="message-header">
							<p>Error</p>

						  </div>
						  <div class="message-body">
						Not all params were set </div>
						</article>
											
					
					<?php
    } ?>
					
					
					
															<?php if (isset($_GET['user_not_found']))
    { ?>
											
											<article class="message is-danger">
  <div class="message-header">
    <p>Error</p>

  </div>
  <div class="message-body">
 User not found  </div>
</article>
											
					
					<?php
    } ?>
					
					
																				<?php if (isset($_GET['wrong_token']))
    { ?>
											
											<article class="message is-danger">
  <div class="message-header">
    <p>Error</p>

  </div>
  <div class="message-body">
Token is wrong!  </div>
</article>
											
					
					<?php
    } ?>
																									<?php if (isset($change_success))
    { ?>
											
											<article class="message is-success">
  <div class="message-header">
    <p>Success</p>

  </div>
  <div class="message-body">
<?php echo $change_success; ?> </div>
</article>
											
					
					<?php
    } ?>
					
					
					
					
					
					
					<div class="box">
                        <form method="POST" action="/?reset">
                            <div class="field">
                                <div class="control">
                                    <input class="input is-large" name="email" type="email" placeholder="Your Email" autofocus="">
                                </div>
                            </div>

                            <div class="field">
                                <div class="control">
                                    <input class="input is-large" name="token" type="text" placeholder="Token" autofocus="">
                                </div>
                            </div>
                            <div class="field">
                                <div class="control">
                                    <input class="input is-large" name="password" type="password" placeholder="New password" autofocus="">
                                </div>
                            </div>




                            <button class="button is-block is-info is-large is-fullwidth">Reset</button>
                        </form>
                    </div>
                    <p class="has-text-grey">
                 
                        <a href="/index.php">Send token</a> &nbsp;·&nbsp;
						 <a href="/manual.php">Manual</a>
                    </p>
					
					<?php
} ?>
					
					
					
					
					
                </div>
            </div>
        </div>
		
		<footer class="footer">
  <div class="content has-text-centered has-text-black">
    <p>
      If you found bugs or didn't recieve email, please contact your network administrator: john@appsec.study
    </p>
  </div>
</footer>
    </section>
</body>

</html>
