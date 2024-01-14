@include('include.header') 

          <section class="section">
        <div class="container">
          <div class="mb-6 columns is-multiline is-centered">
            <div class="column is-8 has-text-centered">
              
              <h2 class="mt-2 mb-4 is-size-1 is-size-3-mobile has-text-weight-bold">CMS</h2>
            </div>
          </div>
		  <div class="mb-5 columns is-multiline">
		  @foreach($challenges as $challenge)
          
            <div class="column is-6 is-4-desktop mb-4">
              <div class="box p-5 has-background-light">
                <div class="mb-4 is-relative">
				  <span><small class="has-text-grey-dark">{{$challenge->available_at}}</small></span>
					@if($challenge->enabled)
                  <span class="mt-3 mr-3 tag is-success" style="position: absolute; top: 0; right: 0; z-index: 1;">Enabled</span>
				@else
					<span class="mt-3 mr-3 tag is-danger" style="position: absolute; top: 0; right: 0; z-index: 1;">Disabled</span>
				@endif
                  
				  
	  
                </div>
              
				   <a href="{{route('view_challenge',['id'=>$challenge->id])}}"><h2 class="mt-2 mb-4 is-size-1 is-size-3-mobile has-text-weight-bold">{{$challenge->title}}</h2></a>

			
                <a href="{{route('edit_challenge',['id'=>$challenge->id])}}">Edit</a>

              </div>
            </div>
			
			@endforeach
</div>
          

        </div>
      </section>
	  @include('include.footer')