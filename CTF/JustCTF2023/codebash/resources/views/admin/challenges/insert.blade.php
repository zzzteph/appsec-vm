
@include('include.header') 

<section class="section">
  <div class="container">
    <div class="columns is-multiline is-centered">
      <div class="column is-8 is-6-desktop">
       
<h2 class="mt-2 mb-4 is-size-1 is-size-3-mobile has-text-weight-bold">Create new challenge</h2>
   <form method="POST" action="{{route('insert_challenge')}}">
		   					@csrf


			<div class="field">
			  <label class="label">Title</label>
				<input class="input" type="text" placeholder="Juicy name" name="title">
			</div>

			<div class="field">
			  <label class="label">Content</label>
			  <div class="control">
				<textarea class="textarea" placeholder="Your code" name="content"></textarea>
			  </div>
			</div>


			<div class="field">
			  <label class="label">Date</label>
			  <div class="control">
				<input class="date" type="date" placeholder="Text input" name="available_at">
			  </div>
			</div>


			<div class="field">
			  <label class="label">Correct answer</label>
			  <div class="control">
				<textarea class="textarea" placeholder="Correct answer to evaluate" name="answer"></textarea>
			  </div>
			</div>






			<div class="field">
			  <div class="control">
				<label class="checkbox">
				  <input type="checkbox" name="enabled">
				 Enabled
				</label>
			  </div>
			</div>



			<div class="field ">
			  <div class="control">
				<button class="button is-link">Create</button>
			  </div>
			</div>
</form>





	   </div>
    </div>
  </div>
</section>
@include('include.footer')