@include('include.header') 


 <section class="section">
 <div class="container" id="leaderboard">
  <h2 class="mb-4 is-size-1 is-size-3-mobile has-text-weight-bold">{{$title}}</h2>
 <!-- <h4 class="mb-5 is-size-4 has-text-weight-bold">Your score: {{Auth::user()->score}}</h4> -->
 <table class="table is-fullwidth">
 <thead>
	<tr>
		<th>#</th>
		<th>User</th>
		<th>Score</th>
	</tr>
 </thead>
 <tbody>
 @foreach ($users as $user)
 <tr>
		<td>{{ $loop->index+1}}</td>
		<td>{{$user['name']}}</td>
		<td>{{$user['score']}}</td>
	</tr>
 
 @endforeach
 </tbody>
 </table>
 </div>
 </section>


                

	  @include('include.footer')