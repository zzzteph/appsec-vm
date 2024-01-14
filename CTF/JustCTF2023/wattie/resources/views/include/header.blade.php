<!DOCTYPE html>
<html lang="en">
<head>
    <title>WattieThePenguin</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto+Mono:400&amp;subset=latin">
    <link rel="stylesheet" href="https://rsms.me/inter/inter.css">
    <link rel="stylesheet" href="{{ asset('assets/css/bulma/bulma.min.css')}}">
        <script src="{{ asset('assets/js/jquery-3.7.1.min.js')}}"></script>
    <script src="{{ asset('assets/js/main.js')}}"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.8.0/styles/default.min.css">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.8.0/highlight.min.js"></script>
        <link href="{{ asset('assets/fontawesome/css/all.css')}}" rel="stylesheet">
         <script src="{{asset('assets/js/vue.js')}}" type="text/javascript"></script>
         <script src="{{asset('assets/js/axios.min.js')}}" type="text/javascript"></script>

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
			<a class="navbar-item" href="/">Main</a>
				<a class="navbar-item" href="{{route('leaderboard')}}">Leaderboard</a>
				<div class="navbar-item">
						<div class="buttons is-size-5">
							<form method="POST" >
								
								 @csrf
								   <a href="{{route('start')}}" class="button is-primary "> New Game</a>
							  </form>
				
						</div>
					</div>	
				</div>		
					   <div class="navbar-end is-size-5">
      <div class="navbar-item">{{Auth::user()->name}}		
				</div>
				</div>
					
					
          </div>
        </div>
      </nav>
                   @if ($errors->any() || Session::has('success'))
<section class="section">
  <div class="container">
    <div class="columns is-multiline is-centered">
      <div class="column is-8">
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
<br/>
@endif
@if (Session::has('success'))

                                                        <article class="message is-success">
  <div class="message-body has-text-left">
   <ul>
<li>{{ Session::get('success') }}</li>
        </ul>
  </div>
</article>



@endif


 </div>
</div>
</div>
</div>
</section>
@endif
    <style>
        .game-container {
            position: relative;
            width: 320px;
            height: 400px;
            border: 4px solid orange;
            overflow: hidden;
			background-color: white;
			  background: repeating-linear-gradient(0deg, #E0E0E0, #E0E0E0 5px, #FFFFFF 5px, #FFFFFF 10px);
			      background-position: 0 0;
    background-color: white; 
        }
		
		   .score-container {
            position: relative;
            width: 320px;

            overflow: hidden;
        }
		
		
        .wattie, .obstacle {
            position: absolute;
            width: 64px;
            height: 64px;
        }
#fish-score-container {
    width: 340px; 
    flex-wrap: wrap;
    display: flex;
    justify-content: start;
    align-items: center;
}

#fish-score-container img {
    width: 32px; 
    height: auto;
    margin: 2px;
}
.flex-container {
    display: flex;
    align-items: center;  
    gap: 10px;            
}
		
    </style>

