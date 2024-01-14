			      <div class="navbar-item has-dropdown is-hoverable">
        <a class="navbar-link" href="{{route('track',['track'=>'websec'])}}">
            {{$title}}
        </a>

        <div class="navbar-dropdown">
		@foreach($menu as $task)
          <a class="navbar-item"  href="{{route('track',['track'=>'websec'])}}#task{{$task->id}}">{{$task->name}}     </a>
	@endforeach
	

      </div>
    </div>
			