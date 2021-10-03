
    </section>    <section class="hero is-fullheight">
        <div class="hero-body">
            <div class="container has-text-centered">
                <div class="column is-4 is-offset-4">
				
											
									<?php
					if(isset($error))
					{?>
						
						
						
						
						
						<article class="message is-danger">
  <div class="message-header">
    <p>Error</p>
  
  </div>
  <div class="message-body">
<?php echo $error;?>
  </div>
</article>
						
						
						
						
					<?php
					}	
					?>
					
				
                    <h3 class="title has-text-black">Sign-in</h3>


                    <hr class="login-hr">
                    <p class="subtitle has-text-black">Please login to proceed.</p>
                    <div class="box">
                        <form method="POST" action="/login">
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
                            <button class="button is-block is-success is-large is-fullwidth" name="submit">Login <i class="fas fa-sign-in-alt"></i></button>
                        </form>

						
						
                    </div>

                </div>
            </div>
        </div>
    </section>