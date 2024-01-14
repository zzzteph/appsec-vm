<!DOCTYPE html>
<html lang="en">
<head>
    <title>Just-CTF</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto+Mono:400&amp;subset=latin">
    <link rel="stylesheet" href="https://rsms.me/inter/inter.css">
    <link rel="stylesheet" href="/bulma.min.css">
    <script src="/main.js"></script>
</head>
<body>
    <div class="">
                
      <div class="columns is-multiline">
        
        <div class="column is-4-desktop">
      
      </div>
        
      </div>
                
      <section class="section pt-0">
        <nav class="navbar py-4">
          <div class="navbar-brand">
            <a class="navbar-item" href="{{route('dashboard')}}">
<img class="image " src="/MOSHED-2022-9-18-15-55-52.gif">
</a>
            <a class="navbar-burger" role="button" aria-label="menu" aria-expanded="false">
              <span aria-hidden="true"></span>
              <span aria-hidden="true"></span>
              <span aria-hidden="true"></span>
            </a>
          </div>
          <div class="navbar-menu">
            <div class="navbar-end">
			
                <x-menu/>
                <x-websec/>
			
			
			
								<div class="navbar-item has-dropdown is-hoverable">
						<a class="navbar-link"  href="{{route('leaderboard',['type'=>'awareness-month'])}}">Leaderboard</a>
						<div class="navbar-dropdown">
						  <a class="navbar-item"  href="{{route('leaderboard',['type'=>'awareness-month'])}}">
							Awareness Month
						  </a>
						  <a class="navbar-item" href="{{route('leaderboard')}}">
							Global
						  </a>
						</div>
			  </div>
			
			
			
			
			<a class="navbar-item" href="{{route('dashboard')}}#flag">Submit Flag</a>
			
			
						      <div class="navbar-item has-dropdown is-hoverable">
        <a class="navbar-link" href="{{route('dashboard')}}">
         About
        </a>

        <div class="navbar-dropdown">
		<a class="navbar-item" href="{{route('rules')}}">Rules</a>
		<a class="navbar-item" href="https://codebash.just-ctf.com" target="_blank">Codebash</a>
		<a class="navbar-item" href="https://novms.com" target="_blank">NoVM</a>
		
      </div>

    </div>
			
				  <a class="navbar-item" href="https://forms.gle/YDtxaR1JFNN6Pt31A" target="_blank">Feedback</a>
			
			
			
      </div>
            <div class="navbar-item"></div>
          </div>
        </nav>

      </section>
         


	@if ($errors->any() || Session::has('success'))
<section class="section">
  <div class="container">
    <div class="columns is-multiline is-centered">
      <div class="column">
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

                
     