<!DOCTYPE html>
<html lang="en">
<head>
    <title>CodeBash</title>
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
                

                
      <section class="section pt-0">
        <nav class="navbar py-4">
          <div class="navbar-brand">
            
            <a class="navbar-burger" role="button" aria-label="menu" aria-expanded="false">
              <span aria-hidden="true"></span>
              <span aria-hidden="true"></span>
              <span aria-hidden="true"></span>
            </a>
          </div>
          <div class="navbar-menu" id="menu">
            <div class="navbar-end">
			<a class="navbar-item" href="https://just-ctf.com" target="_blank">CTF</a>
			<a class="navbar-item" href="{{route('challenges')}}">Challenges</a>
			@auth
				@if(Auth::user()->role==='admin')
				
				
			<div class="navbar-item has-dropdown is-hoverable">
						<a class="navbar-link"  href="{{route('list_challenges')}}">
						  CMS
						</a>

						<div class="navbar-dropdown">
						  <a class="navbar-item"  href="{{route('list_challenges')}}">
							All
						  </a>
						  <a class="navbar-item" href="{{route('new_challenge')}}">
							Add new
						  </a>
						</div>
			  </div>
				
		
				
				
					<div class="navbar-item has-dropdown is-hoverable">
						<a class="navbar-link"  href="{{route('answers')}}" v-if="numberOfToReviewAnswers>0">
						  Answers (@{{ numberOfToReviewAnswers }})
						</a>
						<a class="navbar-link"  href="{{route('answers')}}" v-else>Answers</a>
						<div class="navbar-dropdown">
						  <a class="navbar-item"  href="{{route('answers')}}">
							All (@{{ answers.length }})
						  </a>
						  <a class="navbar-item" href="{{route('answers',['type'=>'review'])}}">
							To Review (@{{ numberOfToReviewAnswers }})
						  </a>
						</div>
			  </div>
				@endif 
			@endauth
			
				<a class="navbar-item" href="{{route('rules')}}">Rules</a>
				<a class="navbar-item" href="{{route('leaderboard')}}">Leaderboard 

@auth
({{Auth::user()->rank}})

@endauth
</a>

@auth
				<a class="navbar-item" href="{{route('profile')}}">
					
						<figure class="image">
			<img class="is-rounded" src="/storage/{{Auth::user()->avatar}}"> 
		</figure>
	
				&nbsp;{{Auth::user()->name}}
			
				</a>
				<div class="buttons">
			<form method="POST"  action="{{route('logout')}}">
		@method('DELETE')
			@csrf
            <button class="button is-small is-black">
				<span class="icon ">
				<i class="fa-solid fa-right-from-bracket"></i>
				</span>
			</button>
			</form>
        </div>
@endauth	
				
				
			</div>
			
            <div class="navbar-item"></div>
          </div>
        </nav>
      </section>
                
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
				
				

                
     