
@include('include.header') 

<section class="section">
  <div class="container">
    <div class="columns is-multiline is-centered">
      <div class="column is-8 ">
     
<h2 class="mt-2 mb-4 is-size-1 is-size-3-mobile has-text-weight-bold"> #{{$answer->challenge->title}}</h2>


<pre>
<code>
{{$answer->challenge->content}}
</code>
</pre>
</div>


<div class="column is-8">
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
	
	</tr>

</thead>

<tbody>

<tr>
	<td>{{$answer->id}}</td>
	<td>{{$answer->created_at}}</td>
	<td>{{$answer->user->name}}</td>
	<td>{{$answer->challenge->id}}</td>
	<td>{{$answer->correct}}</td>
	<td>{{$answer->ai_review}}</td>
	<td>{{$answer->correctness}}</td>
	<td>{{$answer->user_review}}</td>
	<td>{{$answer->reviewed}}</td>
</tr>

</tbody>


</table>
</div>


	 <div class="column is-8">

		<article class="message">
			 <div class="message-header is-success">
				Correct answer			  
			</div>
			<div class="message-body has-text-left">
			{{$answer->challenge->answer}}
			</div>
		</article>
	</div>



	 <div class="column is-8">

		<article class="message">
			 <div class="message-header">
				#{{$answer->id}} - {{$answer->user->name}} 				  
			</div>
			<div class="message-body has-text-left">
			{{$answer->content}}
			</div>
		</article>
	</div>



 <div class="column is-8">
    <div class="columns is-multiline is-centered">
 <div class="column is-4">
 
   <form method="POST" action="{{route('correct_answer',['id'=>$answer->id])}}">
		   					@csrf
@method('put')

			
			<div class="field ">
			  <div class="control">
				<button class="button is-success">Correct</button>
			  </div>
			</div>
</form>
</div>

 <div class="column is-4">
 
   <form method="POST" action="{{route('wrong_answer',['id'=>$answer->id])}}">
		   					@csrf
@method('put')

			
			<div class="field ">
			  <div class="control">
				<button class="button is-danger">Wrong</button>
			  </div>
			</div>
</form>
</div>
</div>

</div>

	   </div>
    </div>

</section>




@include('include.footer')