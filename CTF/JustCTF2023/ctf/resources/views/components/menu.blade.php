			      <div class="navbar-item has-dropdown is-hoverable">
        <a class="navbar-link" href="{{route('dashboard')}}">
            {{$title}}
        </a>

        <div class="navbar-dropdown">
		@foreach($menu as $task)
          <a class="navbar-item"  href="{{route('dashboard')}}#task{{$task->id}}">{{$task->name}}     </a>
	@endforeach
	
	
	<hr class="navbar-divider">
	<a class="navbar-item" href="{{route('archived')}}">Archived</a>
      </div>
    </div>
			