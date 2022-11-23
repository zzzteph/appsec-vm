<!DOCTYPE html>
<html lang="en">
<head>
    <title>FoodDelivery</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://rsms.me/inter/inter.css">
    <link rel="stylesheet" href="/bulma.min.css">
    <script src="/main.js"></script>
</head>
<body>
    <div class="">
                
                

                
      <nav class="navbar py-4">
        <div class="container is-fluid">
          <div class="navbar-brand">
            
            <a class="navbar-burger" role="button" aria-label="menu" aria-expanded="false">
              <span aria-hidden="true"></span>
              <span aria-hidden="true"></span>
              <span aria-hidden="true"></span>
            </a>
          </div>
          <div class="navbar-menu">
            <div class="navbar-start"><a class="navbar-item" href="/main">Home</a>
			</div>
            <div class="navbar-item">
              <div class="buttons">
      <a class="button" href="{{route('settings')}}">Settings</a>				   <form method="POST" action="{{route('logout')}}">
                     @method('delete')
                     @csrf
                       <button class="button has-background-danger-dark has-text-white-bis">
						
						Logout
					  </button>
                  </form>
      </div>
            </div>
          </div>
        </div>
      </nav>
    	@if ($errors->any() || Session::has('success'))

	 <div class="container is-size-5">
@if ($errors->any())
							<article class="message is-danger">
  <div class="message-header">
    <p>Error</p>
  </div>
  <div class="message-body has-text-left">
   <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
  </div>
</article>
<br/>
@endif
@if (Session::has('success'))

							<article class="message is-success">
  <div class="message-header">

  </div>
  <div class="message-body has-text-left">
   <ul>
<li>{{ Session::get('success') }}</li>
        </ul>
  </div>
</article>



@endif


 </div>

@endif            

<section class="section">
  <div class="container">
    <div class="columns is-multiline is-centered">
      <div class="column is-8 is-5-desktop">
        <div class="box p-6 has-background-light has-text-centered">

          <h3 class="mb-5 is-size-4 has-text-weight-bold" contenteditable="false">Change password</h3>
          <form method="POST" action="{{route('change')}}">
                     @csrf
            <div class="field">
              <div class="control">
                <input class="input" type="password" name="new_password" placeholder="New password">
              </div>
            </div>
            <div class="field">
              <div class="control">
                <input class="input" type="password" name="old_password" placeholder="Repeat">
              </div>
            </div>
            <button class="button is-primary mb-4 is-fullwidth">Change </button>


          </form>
        </div>
      </div>
    </div>
  </div>
</section>




    </div>
</body>
</html>
