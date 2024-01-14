
@include('include.header') 

<section class="section">
  <div class="container">
    <div class="columns is-multiline is-centered">
      <div class="column is-10">
       
<h2 class="mt-2 mb-4 is-size-1 is-size-3-mobile has-text-weight-bold"> {{$title}}</h2>




<table class="table is-fullwidth">
<thead>
	<tr>
		<th>#</th>
		<th>Created_at</th>
		<th>User</th>
		<th>Challenge</th>
		<th>Correct</th>
		<th>B0B</th>
		<th>Correctness</th>
		<th>Manual</th>
		<th>Reviewed</th>
		<th></th>
	</tr>

</thead>

<tbody>
@foreach($answers as $answer)

<tr>
<td><a href="{{route('view_answer',['id'=>$answer->id])}}">{{$answer->id}}</a></td>
	<td><a href="{{route('view_answer',['id'=>$answer->id])}}">{{$answer->created_at}}</a></td>
	<td><a href="{{route('view_answer',['id'=>$answer->id])}}">{{$answer->user->name}}</a></td>
	<td><a href="{{route('view_answer',['id'=>$answer->id])}}">{{$answer->challenge->id}}({{$answer->challenge->title}})</a></td>
	<td><a href="{{route('view_answer',['id'=>$answer->id])}}">{{$answer->correct}}</a></td>
	<td><a href="{{route('view_answer',['id'=>$answer->id])}}">{{$answer->ai_review}}</a></td>
	<td><a href="{{route('view_answer',['id'=>$answer->id])}}">{{$answer->correctness}}</a></td>
	<td><a href="{{route('view_answer',['id'=>$answer->id])}}">{{$answer->user_review}}</a></td>
	<td><a href="{{route('view_answer',['id'=>$answer->id])}}">{{$answer->reviewed}}</a></td>
	<td>
	
	   <form method="POST" action="{{route('delete_answer',['id'=>$answer->id])}}">
		   					@csrf
@method('delete')

			
			<div class="field ">
			  <div class="control">
				<button class="button is-danger is-small">delete</button>
			  </div>
			</div>
</form>
	
	</td>
</tr>

@endforeach
</tbody>


</table>










	   </div>
    </div>
  </div>
</section>
@include('include.footer')