

<!DOCTYPE html>
<html lang="en">
<head>
    <title>CryIO</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=JetBrains+Mono:400&amp;subset=latin">
    <link rel="stylesheet" href="{{ asset('assets/css/inter.css')}}">
    <link rel="stylesheet" href="{{ asset('assets/css/bulma.min.css')}}">
    <script src="{{ asset('assets/js/main.js')}}" type="text/javascript"></script>
    <script src="{{ asset('assets/js/jquery-3.6.0.js')}}" type="text/javascript"></script>

	
	
</head>
<body>
    <div class="">
          
<section class="section">
  <div class="container">
    <div class="columns is-multiline is-centered">
      <div class="column is-8 is-5-desktop">
        <div class="box p-6 has-background-light has-text-centered">
          <span class="has-text-grey-dark" contenteditable="false">Sign UP</span>
          <h3 class="mb-5 is-size-4 has-text-weight-bold" contenteditable="false">Join our community</h3>
          <form method="POST" action="{{route('create_account')}}">
		  @csrf
            <div class="field">
              <div class="control">
                <input class="input" type="text" placeholder="Login" name="login" >
              </div>
            </div>
            <div class="field">
              <div class="control">
                <input class="input" type="password" placeholder="Password" name="password">
              </div>
            </div>
            <button class="button is-primary mb-4 is-fullwidth">Sign UP</button>


			   @if ($errors->any() || Session::has('success'))

			  <div class="container">
				<div class="columns is-multiline is-centered">
				  <div class="column ">
					 <div class="container is-size-5">
			@if ($errors->any())
																	<article class="message is-danger">
			  <div class="message-body has-text-left">
			   <ul>
						@foreach ($errors->all() as $error)
							<li>{{ $error }}</li>
						@endforeach
					</ul>
			  </div>
			</article>

			@endif



			 </div>
			</div>
			</div>
			</div>

			@endif






          </form>
		   <p class="has-text-grey-dark">
            <small>
              <span>Already have an account?</span>
              <a href="{{route('login')}}">Sign In</a>
            </small>
          </p>
		  
		  
		  
        </div>
      </div>
    </div>
  </div>
</section>
    </div>
</body>
</html>



