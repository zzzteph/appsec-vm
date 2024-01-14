
@include('include.header') 

<section class="section">
  <div class="container">
    <div class="columns is-multiline is-centered">
      <div class="column is-8 ">
     
<h2 class="mt-2 mb-4 is-size-1 is-size-3-mobile has-text-weight-bold"> #{{$challenge->title}}</h2>


<pre id="code">
<code @copy="handleCopy" @cut="handleCut">
{{$challenge->content}}
</code>
</pre>
</div>


@if($challenge->last_user_answer!==null)
	 <div class="column is-8">
						@if($challenge->last_user_answer->correct==TRUE && $challenge->last_user_answer->reviewed==TRUE)
	 
							<article class="message is-success">
							 <div class="message-header">
							 #{{$challenge->last_user_answer->id}} - correct
							@elseif($challenge->last_user_answer->correct==FALSE && $challenge->last_user_answer->reviewed==TRUE)
								<article class="message is-danger">
							 <div class="message-header">
							 
							#{{$challenge->last_user_answer->id}} - incorrect
							
							@else
								<article class="message is-info">
							 <div class="message-header">
							 
							#{{$challenge->last_user_answer->id}} - in review
							
							@endif
						 
						  
  </div>
  <div class="message-body has-text-left">
{{$challenge->last_user_answer->content}}


<p><i>{{$challenge->last_user_answer->get_info}}</i></p>

  </div>
</article>
</div>
@endif


@if($challenge->to_review_answer===FALSE && $challenge->is_done==FALSE)



	 <div class="column is-8 ">
   <form method="POST" action="{{route('answer',['id'=>$challenge->id])}}">
		   					@csrf

			<div class="field">
			  <label class="label has-text-primary">Your answer</label>
			  <div class="control">
				<textarea class="textarea" placeholder="Your answer" name="answer"></textarea>
			  </div>
			</div>
			
			<div class="field ">
			  <div class="control">
				<button class="button is-link">Submit your answer</button>
			  </div>
			</div>
</form>
</div>


@endif





	   </div>
    </div>

</section>




@include('include.footer')