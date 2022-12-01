@if ($paginator->hasPages())
<div class="page-pagination">
    <ul class="pagination">
        <li>
            <a href="{{ ($paginator->onFirstPage())?'#':$paginator->previousPageUrl() }}" aria-label="Previous">
                <span class="fa fa-arrow-left"></span>
            </a>
        </li>
        @foreach ($elements as $element)
            @if (is_string($element))
            <li><a href="#">{{$element}}</a></li>
            @endif

            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <li class="current"><a href="#">{{$page}}</a></li>
                    @else
                        <li><a href="{{$url}}">{{$page}}</a></li>
                    @endif
                @endforeach
            @endif
        @endforeach
        <li>
            <a href="{{ ($paginator->hasMorePages())?$paginator->nextPageUrl():'#' }}" aria-label="Next">
                <span class="fa fa-arrow-right"></span>
            </a>
        </li>
    </ul>                    
</div>
@endif