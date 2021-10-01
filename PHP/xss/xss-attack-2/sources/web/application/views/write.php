  <div class="row">
    <div class="col">
    <?php
		for($i=0;$i<count($address_book);$i++)
		{
			echo '<h3><a href="/write/'.$address_book[$i]['id'].'">'.$address_book[$i]['user'].'</a></h3>';
		}
	?>	
	
	
	</div>
    <div class="col">
	
   <?php
		$messagescount=count($dialog);
		for($i=0;$i<$messagescount;$i++)
		{
			if($dialog[$i]['sid']==$id || $dialog[$i]['did']==$id){
			
			?>

				<div class="alert" role="alert">
				<?php echo '#'.$dialog[$i]['id'];?>
				<p> From: <a href="/user/<?php echo $dialog[$i]['sid'];?>"> <?php echo $dialog[$i]['suser'];?></a></p>
				<p> To: <a href="/user/<?php echo $dialog[$i]['did'];?>"> <?php echo $dialog[$i]['duser'];?></a></p>
				
				<p>
				<?php echo htmlspecialchars($dialog[$i]['info']);?>
				</p>
				</div>


			<?php	}}
		
		$attributes = array ('id' => 'write');
		echo form_open('/write/'.$id, $attributes);
		echo ' <div class="form-group">';
		$attributes = array ('class' => 'form-control','name'=>'info','value'=>'');
		echo ' <div class="form-group">';
		echo form_textarea($attributes);
		echo "</div>";

		$attributes = array ('class' => 'btn btn-default','value'=>"Send");
		echo ' <div class="form-group">';
		echo form_submit($attributes);
		echo "</div>";

		echo form_close();
	?>

    </div>
  </div>
