@if ($paginator->hasPages())
	
<nav class="pagination" role="navigation" aria-label="pagination">
  <ul class="pagination-list">
 
 
 
 
 
            @foreach ($elements as $element)
                @if (is_array($element))
                    @foreach ($element as $page => $url)
					
				
                        @if ($page == $paginator->currentPage())
                            <li> <a class="pagination-link is-current" class="active" aria-current="page"><span>{{ $page }}</span></a></li>
                        @else
                            <li> <a class="pagination-link" class="active" aria-current="page"  href="{{ $url }}"><span>{{ $page }}</span></a></li>
                        @endif
                    @endforeach
                @endif
            @endforeach
  
  
  
  

  </ul>
</nav>
	
	
	
@endif