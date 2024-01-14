
@include('include.header') 

<section class="section">
  <div class="container">
    <div class="columns is-multiline is-centered">
      <div class="column is-8 ">
     
<h2 class="mt-2 mb-4 is-size-1 is-size-3-mobile has-text-weight-bold">Profile</h2>

      <form method="POST" action="{{route('profile')}}" enctype="multipart/form-data">
	  @method('put')
		   					@csrf

			<div class="field">
			  <label class="label">Your name</label>
			  <div class="control">
				<input class="input" type="text" name="name" value="{{$user->name}}">
			  </div>
			</div>
			
			
			<div class="field">
			<label class="label">Profile picture</label>
			 <div class="control">
				<figure class="image is-64x64">
					<img src="/storage/{{$user->avatar}}">
				</figure>
			  </div>
			</div>
			
			
			
<div class="field ">
			<div id="file-js-example" class="file has-name">
			  <label class="file-label">
				<input class="file-input" type="file" name="avatar">
				<span class="file-cta">
				  <span class="file-icon">
					<i class="fas fa-upload"></i>
				  </span>
				  <span class="file-label">
					Choose a file…
				  </span>
				</span>
				<span class="file-name">
				  No file uploaded
				</span>
			  </label>
			</div>
</div>
<script>
  const fileInput = document.querySelector('#file-js-example input[type=file]');
  fileInput.onchange = () => {
    if (fileInput.files.length > 0) {
      const fileName = document.querySelector('#file-js-example .file-name');
      fileName.textContent = fileInput.files[0].name;
    }
  }
</script>

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