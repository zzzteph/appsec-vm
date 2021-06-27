<section class="articles">
     <div class="container">






<div class="card">
  <div class="card-content">
    <div class="media">
      <div class="media-content">
        <p class="title is-4"><?php echo $post['header'];?></a> <?php echo "(".$post['likes']." likes)"?>
	
		<?php if($isliked) {?>
		
		<a class="button is-danger is-small" href="/dislike/<?php echo $post['id'];?>">Dislike</a>
		
		<?php } else { ?>
		
		
		<a class="button is-success is-small"  href="/like/<?php echo $post['id'];?>">Like</a>
		<?php } ?>
		
		
		</p>
        <p class="subtitle is-6"><strong><?php echo $post['author'];?></strong></p>
      </div>
    </div>

    <div class="content">
			<?php echo $post['content'];?>

<?php

if($post['likes']>5)
{  ?>
	
<article class="message is-primary">
  <div class="message-header">
    <p>Bob</p>
    <button class="delete" aria-label="delete"></button>
  </div>
  <div class="message-body">
	Thank you very much! I love you all, my next topic will be: <strong>what if your child is martian?</strong>
  </div>
</article>

<?php }

?>


    </div>
  </div>
</div>
	</div>
	</section>

<section class="section">
<div class="container">
<?php foreach($post['comments'] as $comment) { ?>
	

<article class="media">
  <div class="media-content">
    <div class="content">
      <p>
        <strong><?php echo $comment['user'];?></strong>
        <br>
      <?php echo $comment['content'];?>
      </p>
    </div>
  </div>
</article>

<?php } ?>
	</div>
	</section>
<section class="section">
<div class="container">

<form method="POST" action="/addcomment">
<input type="hidden" name="post_id" value="<?php echo $post['id'];?>">
  <div class="media-content">
    <div class="field is-fullwidth">
      <p class="control is-fullwidth">
        <textarea class="textarea is-fullwidth" name="comment" placeholder="Add a comment..."></textarea>
      </p>
    </div>
    <nav class="level">
      <div class="level-left">
        <div class="level-item">
          <button class="button is-success" name="submit">Add comment</a>
        </div>
      </div>
    </nav>
  </div>
  </form>

	</div>
	</section>


