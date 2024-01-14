
 @include('include.header')    



      <section class="section">
        <div class="container">
		<h1 class="title">Wattie the Penguin!....try #{{$game->id}}</h1>
		@if($game->score>=25)
			
			<h2 class="subtitle">Your rank is <b>S</b>! </h2>
			@if($game->difficulty=="easy")
				<h2 class="subtitle">JUST-CTF{Wattie_Penguin}</h2>
			@endif
			
			@if($game->difficulty=="hard")
			<h2 class="subtitle">JUST-CTF{Fish_Eater}</h2>
			@endif
		@elseif($game->score<25 && $game->score>=20)
			<h2 class="subtitle">Your rank is <b>A</b>! </h2>
		@elseif($game->score<20 && $game->score>=15)
			<h2 class="subtitle">Your rank is <b>B</b>! </h2>
		@elseif($game->score<15 && $game->score>=10)
			<h2 class="subtitle">Your rank is <b>C</b>! </h2>
		@elseif($game->score<10 && $game->score>=5)
			<h2 class="subtitle">Your rank is <b>D</b>! </h2>
		@else
			<h2 class="subtitle">Your rank is <b>F</b>! </h2>
		@endif
		<hr/>
		<h1 class="title">Your score is <b>{{$game->score}}</b>!</h1>
							<div id="fish-score-container">
				
		@for ($i = 0; $i < $game->score; $i++)
				
        <img src="https://wattie.justctf.online/fish.svg" alt="Description">

		@endfor
	</div>
        </div>
      </section>
                
     
        

@include('include.footer')