<?php
require_once('./settings.php');
if(!isset($_SESSION['user_id']))
{
	header('Location: /index.php');
	exit;
}
$user_id=$_SESSION['user_id'];
if (isset($_POST['paste']) && strlen($_POST['paste'])>3 && isset($_POST['title']) && strlen($_POST['title'])>3 && strlen($_POST['title'])<30)
{

		$insertedPaste = $client->secrets->posts->insertOne([
			'title' => (string) $_POST['title'],
			'content' => (string) $_POST['paste'],
			'user_id' => $_SESSION['user_id'],
			'created_at' => time()
		]);


}




	$posts = $client->secrets->posts->find(['user_id'=> $_SESSION['user_id']], [ 'sort'=>['created_at'=>-1] ]);

?>


<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="/bulma.min.css">
  </head>
<body>

    <section class="section">
	
	 <div class="container is-size-5">
<nav class="navbar" role="navigation" aria-label="main navigation">
  <div class="navbar-brand">


    <a role="button" class="navbar-burger" aria-label="menu" aria-expanded="false" data-target="navbarBasicExample">
      <span aria-hidden="true"></span>
      <span aria-hidden="true"></span>
      <span aria-hidden="true"></span>
    </a>
  </div>

  <div id="navbarBasicExample" class="navbar-menu">
    <div class="navbar-start">
      <a class="navbar-item" href="/">
        SecretsBin
      </a>
	  <?php if(isset($_SESSION['user_id'])){?>
      <a class="navbar-item"  href="/secret.php">
        Secret
      </a>
	  <?php }?>
    </div>

    <div class="navbar-end">
      <div class="navbar-item">
		<div class="buttons">
		  <?php if(!isset($_SESSION['user_id'])){?>
		
          <a class="button is-success is-size-5" href="/login.php">
            Log in
          </a>
		  <?php } else { ?>
		  
		    <a class="button is-danger is-size-5" href="/logout.php">
            Logout
          </a>
		  <?php } ?>
		  
		  
		  
        </div>
 
      </div>
	  

	  
	  
	  
    </div>
  </div>
</nav>
		</div>

    </section>

	
	
	
	<section class="section">
<div class="container">
<table class="table is-fullwidth">

<thead>
	<tr>
		<th> Your paste</th>
			<th></th>
	<tr>

</thead>
<tbody>

  <?php foreach ($posts as $post){		?>
	<tr>
  
			<td><a href="/view.php?id=<?php echo $post->{'_id'}; ?>"><?php echo $post->{'title'}; ?></a></td>
			
  <td><a class="button is-success" href="/edit.php?id=<?php echo $post->{'_id'}; ?>">edit</a></td>
			

	</tr>

<?php } ?>
 
 
 </tbody>
 </table>
 </div>


    </section>

	
		<section class="section">
<div class="container">
<h1 class="title">Create secret paste</h1>
<form method="POST" action="/secret.php">
  <div class="media-content">
  
  <div class="field">
  <label class="label">Name</label>
  <div class="control">
    <input class="input" type="text" name="title" placeholder="Title input">
  </div>
</div>
  
  
    <div class="field is-fullwidth">
      <p class="control is-fullwidth">
        <textarea class="textarea is-fullwidth" name="paste" placeholder="Add a comment."></textarea>
      </p>
    </div>
    <nav class="level">
      <div class="level-left">
        <div class="level-item">
          <button class="button is-success" name="submit">Generate paste</a>
        </div>
      </div>
    </nav>
  </div>
  </form>


    </div>

    </section>
	
	



</body>
</html>