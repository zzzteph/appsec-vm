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
	<link href="{{ asset('fontawesome/css/all.css')}}" rel="stylesheet">
	<script src="{{ asset('assets/js/vue.js')}}" type="text/javascript"></script>
	<script src="{{ asset('assets/js/axios.min.js')}}" type="text/javascript"></script>
    
</head>
<body>
    <div class="">
                
      <nav class="navbar py-4">
        <div class="container">
          <div class="navbar-brand">
            
            <a class="navbar-burger" role="button" aria-label="menu" aria-expanded="false">
              <span aria-hidden="true"></span>
              <span aria-hidden="true"></span>
              <span aria-hidden="true"></span>
            </a>
          </div>
          <div class="navbar-menu">
            <div class="navbar-start">
			  <a class="navbar-item" href="{{route('dashboard')}}">Home</a>
	
			
			</div>
            
          </div>
		  
		   <div class="navbar-end is-size-5">
      <div class="navbar-item">
	  
	  
	  
        <div class="buttons is-size-5">

				   <form method="POST" action="{{route('logout')}}">
                     @method('delete')
                     @csrf
                       <button class="button has-background-danger-dark has-text-white-bis">
						
						<span class="icon is-small">
						  <i class="fas fa-sign-out-alt"></i>
						</span>
					  </button>
                  </form>

        </div>

		



      </div>
    </div>
		  
		  
        </div>
      </nav>
              