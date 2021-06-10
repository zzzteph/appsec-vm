<section class="articles">
     <div class="container">

		<?php foreach($posts as $post)
		{
			?>


<div class="card">
  <div class="card-content">
    <div class="media">
      <div class="media-content">
        <p class="title is-4"><a href="/posts/<?php echo $post['id'];?>"><?php echo $post['header'];?></a> <?php echo "(".$post['likes']." likes)"?></p>
        <p class="subtitle is-6"><strong><?php echo $post['author'];?></strong></p>
      </div>
    </div>

    <div class="content">
			<?php echo $post['content'];?>

    </div>
  </div>
</div>

<?php 
		}
		?>

	</div>
	</section>
