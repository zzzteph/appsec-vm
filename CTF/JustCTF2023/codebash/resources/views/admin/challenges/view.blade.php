
@include('include.header') 

<section class="section">
  <div class="container">
    <div class="columns is-multiline is-centered">
      <div class="column is-8 is-6-desktop">
       
<h2 class="mt-2 mb-4 is-size-1 is-size-3-mobile has-text-weight-bold"> #{{$challenge->title}}</h2>


<pre>
<code>
{{$challenge->content}}
</code>
</pre>

			<div class="field">
			  <label class="label">Your answer</label>
			  <div class="control">
				<textarea class="textarea" placeholder="Textarea" ></textarea>
			  </div>
			</div>
			<div class="field ">
			  <div class="control">
				<button class="button is-link">Submit your answer</button>
			  </div>
			</div>







	   </div>
    </div>
  </div>
</section>
@include('include.footer')