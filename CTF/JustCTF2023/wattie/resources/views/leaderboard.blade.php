
            @include('include.header')    
  
                
           <section class="section">
        <div class="container">
		<h1 class="title">Global Leaderboard</h1>
		<hr/>
          <div class="is-vcentered columns">
		  

            <div class="column is-12">
			  <table class="table is-fullwidth">
				<thead>
					<tr>
					<th></th>
						<th>User</th>
						<th>Difficulty</th>
						<th>Score</th>
				</thead>
				<tbody>
				@foreach ($game as $entry)
				<tr>
					<td>{{$loop->index+1}}</td>
					<td><a href="{{route('game',['id'=>$entry->id])}}">{{$entry->user->name}}</a></td>
					
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