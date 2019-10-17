<!-- NAVBAR
================================================== -->
<header id="header-wrap" class="navbar-wrapper">
	<div class="container">
		<nav class="navbar navbar-inverse navbar-static-top">
			<div class="container">
				<div class="navbar-header">
					<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
						<span class="sr-only">Toggle Navigation</span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
					<div class="navbar-brand">
						<div class="logo pull-left">
							@if ( isset( $logo ) || !empty( $logo ) )
								<a href="{{ URL::to('/') }}"><img src="{{ url('/img/gallery/' . $logo->media_name ) }}" class="img-responsive"></a>
							@endif
						</div>						
						<div class="logo-wrap hidden-xs">
							@if ( $site_identity->site_display_assets === 'true' || empty( $logo ))
								<h1 class="logo_text">
									<a href="{{ URL::to('/') }}">{{ $site_identity->site_title }}</a>
								</h1>
								@if ( $site_identity->site_tag_line )
									<p class="site-description">{{ $site_identity->site_tag_line }}</p>
								@endif
							@endif
						</div>					
					</div>
				</div>
				<div id="navbar" class="navbar-collapse collapse">
	                @php
	                    $parent = '0';
	                @endphp
					@if ( $menu_nav )
						<ul class="nav navbar-nav">
			                @foreach ($menu_nav as $menu)
			                	@php
			                		$modal = '';
			                		
			                		 if($menu->pop_m == "1"){
			                		 	$modal = 'data-toggle="modal" data-target="' . $menu->link . '"';
			                		 }	

			                	@endphp
			                    @if($menu->parent_id == $parent)
			                    	<li @if(strtolower($menu->label) == \Request::path() )    class="active" @else @endif>
			                            <a href="{{ $menu->link }}"  @if($menu->tab_status == '1') target="_blank" @endif @if(!empty ($menu->link_rel)) rel="{{$menu->link_rel}}" @endif  title="{{$menu->title_attrib}}"  @if(count($menu->children)>0) class="dropdown-toggle" data-toggle="dropdown" aria-expanded="true" @endif {!! $modal !!} >
			                            	{{ ucfirst($menu->label) }}
			                            	@if(count($menu->children)>0)<b class="caret" data-toggle="dropdown"></b>@endif
			                            </a>
			                        </li>
		                            @if(count($menu->children)>0)<ul class="dropdown-menu dropdown-messages">@endif
			                            @foreach ($menu->children as $children)
		                                    <li>
		                                        <a href="{{ $children->link }}"  @if($children->tab_status == '1') target="_blank" @endif @if(!empty ($children->link_rel)) rel="{{$children->link_rel}}" @endif  title="{{$children->title_attrib}}" >{{ucfirst($menu->label)}}</a>
		                                    </li>
			                            @endforeach
		                            @if(count($menu->children)>0)</ul>@endif
			                            
			                    @endif
			                @endforeach
		                </u>
					@endif
				</div>
			</div>
		</nav>
	</div>
</header>