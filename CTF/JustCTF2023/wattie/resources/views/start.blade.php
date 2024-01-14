
            @include('include.header')    
  
      <section class="section">
        <div class="container">
		<h1 class="title">Wattie the Penguin: New Game</h1>
		<h2 class="subtitle">Choose your the difficulty</h2>
		<hr/>
          <div class="is-vcentered columns">
		  
            <div class="column is-6">
              
			   <form method="POST" action="{{route('start')}}">
                     @csrf
					 <input type="hidden" name="difficulty" value="easy">
                       <button class="button is-block is-primary is-large is-fullwidth"> Easy

                                          </button>
                  </form>

            </div>
            <div class="column is-6">
						   <form method="POST" action="{{route('start')}}">
                     @csrf
              <input type="hidden" name="difficulty" value="hard">
			  	                       <button class="button is-block is-danger is-large is-fullwidth"> Hard

                                          </button>
			 </form>
            </div>
          </div>
        </div>
      </section>
                
           <section class="section">
        <div class="container">
		<h1 class="title">Your game score</h1>
		<hr/>
          <div class="is-vcentered columns">
		  

            <div class="column is-12">
			  <table class="table is-fullwidth">
				<thead>
					<tr>
						<th>Date</th>
						<th>Difficulty</th>
						<th>Score</th>
				</thead>
				<tbody>
				@foreach ($game as $entry)
				<tr>
					<td><a href="{{route('game',['id'=>$entry->id])}}">{{$entry->started_at}}</a></td>
					
					@if($entry->difficulty=="easy")

					<td><span class="tag is-success">{{$entry->difficulty}}</span></td>
					@else
						<td><span class="tag is-danger">{{$entry->difficulty}}</span></td>
					@endif
					
					<td><a href="{{route('game',['id'=>$entry->id])}}">{{$entry->score}}</a></td>
				</tr>
			@endforeach
				
				
				</tbody>
			  </table>
            </div>
          </div>
        </div>
      </section>
                
                

@include('include.footer')