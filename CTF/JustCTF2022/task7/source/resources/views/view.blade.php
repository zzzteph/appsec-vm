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
   			   <form method="POST" action="{{route('logout')}}">
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
                

	  

<section class="section">
  <div class="container">
    <div class="columns is-multiline is-centered">
      <div class="column is-8 is-6-desktop">
        <div class="mb-4 box p-6 is-relative has-background-light">
          <span class="mt-4 ml-4" style="position: absolute; top: 0; left: 0;">
            <svg width="30" height="25" viewBox="0 0 30 25" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path d="M7.24 24.544C4.97867 24.544 3.272 23.7333 2.12 22.112C1.01067 20.448 0.456 18.144 0.456 15.2C0.456 12 1.26667 9.184 2.888 6.752C4.50933 4.27733 7.02667 2.22933 10.44 0.607998L12.744 5.344C10.696 6.24 9.16 7.34933 8.136 8.672C7.112 9.952 6.6 11.552 6.6 13.472C6.728 13.4293 6.94133 13.408 7.24 13.408C8.776 13.408 10.0773 13.8773 11.144 14.816C12.2107 15.7547 12.744 17.0347 12.744 18.656C12.744 20.448 12.232 21.8773 11.208 22.944C10.184 24.0107 8.86133 24.544 7.24 24.544ZM23.88 24.544C21.6187 24.544 19.912 23.7333 18.76 22.112C17.6507 20.448 17.096 18.144 17.096 15.2C17.096 12 17.9067 9.184 19.528 6.752C21.1493 4.27733 23.6667 2.22933 27.08 0.607998L29.384 5.344C27.336 6.24 25.8 7.34933 24.776 8.672C23.752 9.952 23.24 11.552 23.24 13.472C23.368 13.4293 23.5813 13.408 23.88 13.408C25.416 13.408 26.7173 13.8773 27.784 14.816C28.8507 15.7547 29.384 17.0347 29.384 18.656C29.384 20.448 28.872 21.8773 27.848 22.944C26.824 24.0107 25.5013 24.544 23.88 24.544Z" fill="#00d1b2"></path>
            </svg>
          </span>
          <p class="subtitle has-text-grey">{!! $message->message !!}</p>
        </div>
      </div>
    </div>
  </div>
</section>


	  
	  
	  
    </div>
</body>
</html>
