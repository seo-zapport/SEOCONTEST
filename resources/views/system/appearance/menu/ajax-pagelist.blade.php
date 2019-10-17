
 <ul class="list-group">
	@if(!empty($pagelist))
	  @foreach ( $pagelist as $pages )
	    <li class="list-group-select">
	      <label for="list_item_{{ $pages->id }}">
	      <input type="checkbox" class="check-item check page-check" value="{{ $pages->page_title }}" data-id="{{ $pages->id }}" @if(ucfirst(substr(Route::currentRouteName(),5)) =="Create") disabled @endif> 
	      {{ $pages->page_title }} @if(Auth::user()->status_id !='4') - {{str_replace('http://', '',$pages->merchant_name)}} @endif
	      </label>
	    </li>
	  @endforeach
	@endif  
 </ul> <!--.list-group-->