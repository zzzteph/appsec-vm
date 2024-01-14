
@include('include.header') 

<section class="section">
  <div class="container">
    <div class="columns is-multiline is-centered">
      <div class="column is-10">
       
<h2 class="mt-2 mb-4 is-size-1 is-size-3-mobile has-text-weight-bold"> Leaderboard</h2>

@auth
<h3 class="mt-2 mb-4 is-size-2 is-size-4-mobile"> Your rank is {{Auth::user()->rank}} with score {{Auth::user()->score}}</h3>
@endauth

{{$users->links()}}
<table class="table is-fullwidth">
<thead>
	<tr>
		<th>#</th>
		<th></th>
		<th>Name</th>
		<th>Score</th>
	</tr>

</thead>

<tbody>
@foreach($users as $user)

<tr>
	<td>{{$rank++}}</td>
	<td>
		<figure class="image is-64x64">
			<img src="/storage/{{$user->avatar}}">
		</figure>
	</td>
	<td>{{$user->name}}</a></td>
	<td>{{$user->score}}</a></td>
</tr>

@endforeach
</tbody>


</table>










	   </div>
    </div>
  </div>
</section>
@include('include.footer')