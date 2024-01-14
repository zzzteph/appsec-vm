
@include('include.header') 

<section class="section">
  <div class="container">
    <div class="columns is-multiline is-centered">
      <div class="column is-8 is-6-desktop">
       
<h2 class="mt-2 mb-4 is-size-1 is-size-3-mobile has-text-weight-bold">Update the challenge</h2>
   <form method="POST" action="{{route('update_challenge',['id'=>$challenge->id])}}">
   @method('put')
		   					@csrf


			<div class="field">
			  <label class="label">Title</label>
				<input class="input" type="text" placeholder="Juicy name" name="title" value="{{$challenge->title}}">
			</div>

			<div class="field">
			  <label class="label">Content</label>
			  <div class="control">
				<textarea class="textarea" placeholder="Textarea" name="content">{{$challenge->content}}</textarea>
			  </div>
			</div>


			<div class="field">
			  <label class="label">Date</label>
			  <div class="control">
				<input class="date" type="date" placeholder="Text input" name="available_at" value="{{$challenge->available_at}}">
			  </div>
			</div>


			<div class="field">
			  <label class="label">Correct answer</label>
			  <div class="control">
				<textarea class="textarea" placeholder="Textarea" name="answer">{{$challenge->answer}}</textarea>
			  </div>
			</div>





			<div class="field">
			  <div class="control">
				<label class="checkbox">
				@if($challenge->enabled)
				  <input type="checkbox" name="enabled" checked>
			  @else
				  <input type="checkbox" name="enabled">
			  @endif
				 Enabled
				</label>
			  </div>
			</div>



			<div class="field ">
			  <div class="control">
				<button class="button is-link">Update</button>
			  </div>
			</div>
</form>





	   </div>
    </div>
  </div>
</section>
@include('include.footer')