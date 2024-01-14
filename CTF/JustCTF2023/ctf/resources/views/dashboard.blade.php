@include('include.header') 


 <section class="section">
        <div class="container" id="tasks">
		@foreach ($tasks as $task)
          <div class="mb-5 columns is-multiline is-vcentered box" id="task{{$task->id}}">
            <div class="column is-half">
              <div>

                <h2 class="my-4 is-size-3 is-size-4-mobile has-text-weight-bold">
				
				@if($task->is_done)
					<s>{{$task->name}}</s>
				@else
				{{$task->name}}
				
				@endif
				
				
				
				
				</h2>
				 <span><small class="">Flags: {{$task->done}} of {{$task->flags_count}}</small></span>
				 @if($task->is_done)
				  <span><small class="">Done!</small></span>
				@endif
                <p class="subtitle mt-4">{!! $task->description !!}</p>

              </div>
            </div>

			@if(count($task->list())>0)
			  <div class="column is-half">
			 <table class="table is-fullwidth">
			 <thead>
				<tr>
					<th>latest_flag_submissions</th>
				</tr>
			 </thead>
			 <tbody>
			 @foreach ($task->user_flags as $entry)
			 <tr>
					<td>{{$entry->user->name}}</td>
				</tr>
			     @if ($loop->index >= 4)
        @break
    @endif
			 @endforeach
			 </tbody>
			 </table>
			 </div>
@endif


          </div>
		 
	@endforeach
          
          

        </div>
      </section>
                
      <section class="section">
        <div class="container" id="flag">
          <div class="box p-6">
            <div class="is-vcentered columns is-multiline">
              <div class="column is-8-desktop mb-3">
                <div>
                  <h3 class="is-size-2 is-size-3-mobile mb-2 has-text-weight-bold">Submit a flag</h3>
                  
                </div>
              </div>
              <div class="column is-4-desktop">
                    <form method="POST" action="{{route('submit-flag')}}">
						@csrf
                  <div class="is-flex">
                    <div class="control mr-2 is-flex-grow-1">
                      <input class="input" type="text" name="flag" placeholder="Your flag">
                    </div>
                    <button class="button is-primary">Send</button>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </section>
	  @include('include.footer')