@include('include.header') 

      <section class="section">
        <div class="container" id="rules">
          <div class="columns is-multiline">
            <div class="column is-6">
              <div class="box p-6">
                <div class="has-text-centered">
                  <span class="has-text-light mx-auto mb-4 is-flex has-background-primary is-justify-content-center is-align-items-center" style="width: 56px; height: 56px; border-radius: 50% !important;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewbox="0 0 24 24" class=""><path d="M11.99 2C6.47 2 2 6.48 2 12s4.47 10 9.99 10C17.52 22 22 17.52 22 12S17.52 2 11.99 2zM12 20c-4.42 0-8-3.58-8-8s3.58-8 8-8 8 3.58 8 8-3.58 8-8 8zm.5-13H11v6l5.25 3.15.75-1.23-4.5-2.67z"></path></svg>
                  </span>
                  <h5 class="mb-3 is-size-5 has-text-weight-bold">Time</h5>
                  <p class="">Hackquest lasts from 3 (12PM CET) - 28 October(12PM CET). Each new task will appear on Monday or Wednesday at 12 PM CET, and will last for a week. We will announce winners at 28 Oct.</p>
                </div>
              </div>
            </div>
            <div class="column is-6">
              <div class="box p-6">
                <div class="has-text-centered">
                  <span class="has-text-light mx-auto mb-4 is-flex has-background-primary is-justify-content-center is-align-items-center" style="width: 56px; height: 56px; border-radius: 50% !important;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewbox="0 0 24 24" class=""><path d="m12.36 6 .4 2H18v6h-3.36l-.4-2H7V6h5.36M14 4H5v17h2v-7h5.6l.4 2h7V6h-5.6L14 4z"></path></svg>
                  </span>
                  <h5 class="mb-3 is-size-5 has-text-weight-bold">Flags</h5>
                  <p class="">You need to find and exploit vulnerabilities in tasks. Your goal is to find flag - a secret string.      You can submit a flag in form below.Have any questions? Join our #community-ctf channel in slack!
 </p>
                </div>
              </div>
            </div>
            <div class="column is-6">
              <div class="box p-6">
                <div class="has-text-centered">
                  <span class="has-text-light mx-auto mb-4 is-flex has-background-primary is-justify-content-center is-align-items-center" style="width: 56px; height: 56px; border-radius: 50% !important;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewbox="0 0 24 24" class=""><path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 16H5l4-4 4 4 6-6v6zm0-8.5-6 6-4-4-4 4V5h14v5.5zM13.5 9V6H12v6h1.5zm3.7 3-2-3 2-3h-1.7l-2 3 2 3zM11 10.5H8.5v-.75H11V6H7v1.5h2.5v.75H7V12h4z"></path></svg>
                  </span>
                  <h5 class="mb-3 is-size-5 has-text-weight-bold">Score</h5>
                  <p class="">First person who submits a flag gets 100 points. Second - 75, third - 50, 4-th 25, and the rest - 10. You will see the scoretable at the end of the page. It's prohibited to share hints and flags with other participants.</p>
                </div>
              </div>
            </div>
            <div class="column is-6">
              <div class="box p-6">
                <div class="has-text-centered">
                  <span class="has-text-light mx-auto mb-4 is-flex has-background-primary is-justify-content-center is-align-items-center" style="width: 56px; height: 56px; border-radius: 50% !important;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewbox="0 0 24 24" class=""><path d="M20 4H4c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 14H4V6h16v12zM4 0h16v2H4zm0 22h16v2H4zm8-10a2.5 2.5 0 0 0 0-5 2.5 2.5 0 0 0 0 5zm0-3.5c.55 0 1 .45 1 1s-.45 1-1 1-1-.45-1-1 .45-1 1-1zm5 7.49C17 13.9 13.69 13 12 13s-5 .9-5 2.99V17h10v-1.01zm-8.19-.49c.61-.52 2.03-1 3.19-1 1.17 0 2.59.48 3.2 1H8.81z"></path></svg>
                  </span>
                  <h5 class="mb-3 is-size-5 has-text-weight-bold">Join #community-ctf in slack!</h5>
                  <p class="">Feel free to join our ctf trainings and workshops in slack by #community-ctf channel. If the task is broken, feel free to notify about that through #community-ctf slack channel. </p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>

 <section class="section">
 <div class="container" id="leaderboard">
 <h3 class="mb-5 is-size-4 has-text-weight-bold">Scoreboard</h3>
  <h4 class="mb-5 is-size-4 has-text-weight-bold">Your score: {{Auth::user()->score}}</h4>
 <table class="table is-fullwidth">
 <thead>
	<tr>
		<th>#</th>
		<th>User</th>
		<th>Score</th>
	</tr>
 </thead>
 <tbody>
 @foreach ($users as $user)
 <tr>
		<td>{{ $loop->index+1}}</td>
		<td>{{$user->name}}</td>
		<td>{{$user->score}}</td>
	</tr>
 
 @endforeach
 </tbody>
 </table>
 </div>
 </section>



 <section class="section">
        <div class="container" id="tasks">
		@foreach ($tasks as $task)
          <div class="mb-5 columns is-multiline is-vcentered">
            <div class="column">
              <div>

                <h2 class="my-4 is-size-3 is-size-4-mobile has-text-weight-bold">
				
				@if($task->is_done)
					<s>Task {{$task->id}}:{{$task->name}}</s>
				@else
				Task {{$task->id}}:{{$task->name}}
				
				@endif
				
				
				
				
				</h2>
				 <span><small class="">Flags: {{$task->done}} of {{$task->flags_count}}</small></span>
				 @if($task->is_done)
				  <span><small class="">Done!</small></span>
				@endif
                <p class="subtitle mt-4">{!! $task->description !!}</p>

              </div>
            </div>
</div>
<div class="mb-5 columns is-multiline is-vcentered">
			@if(count($task->list())>0)
			  <div class="column">
		   <p class="subtitle mt-4">Top 5 "{{$task->name}}" leaderboard</p>
			 <table class="table is-fullwidth">
			 <thead>
				<tr>
					<th>#</th>
					<th>User</th>
				</tr>
			 </thead>
			 <tbody>
			 @foreach ($task->list() as $name=>$value)
			 <tr>
					<td>{{ $loop->index+1}}</td>
					<td>{{$name}}</td>
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