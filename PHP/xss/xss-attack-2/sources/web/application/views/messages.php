


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

    </div>
  </div>
  <hr>
    <div class="row">
    <div class="col">
	Latest messages <a href="/latest">read </a>	
	   </div>
  </div>