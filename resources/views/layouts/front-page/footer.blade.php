<footer>
	<div class="footer-socket">
		<hr class="style-two">
		<div class="container">
			<nav class="navbar nav-foot">				
			    @php
	                $parent = '0';
	            @endphp
				@if ( $menu_nav_footer )
					<ul class="nav navbar-nav">
		                @foreach ($menu_nav_footer as $menu)
		                	@php
		                		$modal = '';
		                		
		                		 if($menu->pop_m == "1"){
		                		 	$modal = 'data-toggle="modal" data-target="' . $menu->link . '"';
		                		 }	

		                	@endphp
		                    @if($menu->parent_id == $parent)
		                    	<li @if(strtolower($menu->label) == \Request::path() )    class="active" @else @endif>
		                            <a href="{{ $menu->link }}"  @if($menu->tab_status == '1') target="_blank" @endif @if(!empty ($menu->link_rel)) rel="{{$menu->link_rel}}" @endif  title="{{$menu->title_attrib}}"  @if(count($menu->children)>0) class="dropdown-toggle" data-toggle="dropdown" aria-expanded="true" @endif {!! $modal !!} >
		                            	{{ $menu->label }}
		                            	@if(count($menu->children)>0)<b class="caret" data-toggle="dropdown"></b>@endif
		                            </a>
		                        </li>
	                            @if(count($menu->children)>0)<ul class="dropdown-menu dropdown-messages">@endif
		                            @foreach ($menu->children as $children)
	                                    <li>
	                                        <a href="{{ $children->link }}"  @if($children->tab_status == '1') target="_blank" @endif @if(!empty ($children->link_rel)) rel="{{$children->link_rel}}" @endif  title="{{$children->title_attrib}}" >{{ $children->label }}</a>
	                                    </li>
		                            @endforeach
	                            @if(count($menu->children)>0)</ul>@endif
		                            
		                    @endif
		                @endforeach
	                </u>
				@endif
			</nav>		
		</div>
		<hr class="style-two">
	</div>
	<div class="footer-copyright">
		@php
			if ( $logo_settings->footer_link_opt ){
				$footer_link_opt = json_decode($logo_settings->footer_link_opt);
			}else{
				$footer_link_opt = '';
			}
			if( isset( $logo_settings->footer_copyright_opt ) || !empty($logo_settings->footer_copyright_opt)){
				$footer_text = $logo_settings->footer_copyright_opt;
			}else{
				$footer_text = 'SEOContest';
			}
		@endphp
		<div class="container">
			<p class="text-center">
				<!--&copy; <a href="{{ $footer_link_opt->link__opt }}" title="{{ $footer_link_opt->link_title_opt }}" rel="" target="">{{ ucfirst($footer_link_opt->link_name_opt) }}</a> {{ $footer_text }}-->
					&copy; <a href="/" title="{{ $footer_link_opt->link_title_opt }}" rel="" target="">{{ ucfirst($footer_link_opt->link_name_opt) }}</a> {{ $footer_text }}
			</p>
		</div>
	</div>
</footer>
<script src="{{ asset('/js/jquery-2.1.1.js') }}"></script>
<script src="{{ asset('/js/bootstrap.min.js') }}"></script>
@if ( Request::is('/') )
	{{-- <script src="https://www.google.com/recaptcha/api.js" async defer></script> --}}
	<script src='https://www.google.com/recaptcha/api.js' async defer></script>
	<script src="{{ asset('/js/system-js/registration.js') }}"></script>
	<script src="{{ asset('/js/plugins/validate/jquery.validate.min.js') }}"></script>
	<script src="{{ asset('/js/plugins/timeTo/jquery.time-to.js') }}"></script>
	<script src="{{ asset('/js/plugins/jquery-counter/jquery.counter.js') }}"></script>
	<script type="text/javascript">
		$(document).ready(function(){
			$('#limitTimePicker').timeTo({
				timeTo: new Date(new Date('Tue Jan 22 2018 12:00:00 GMT+0800 (Malay Peninsula Standard Time)')),
				displayDays: 2,
				displayCaptions: true,
				fontSize: 42,
    			captionSize: 12
			});
			$('#announcementTimePicker').timeTo({
				timeTo: new Date(new Date('Tue Jan 22 2018 12:00:00 GMT+0800 (Malay Peninsula Standard Time)')),
				displayDays: 2,
				displayCaptions: true,
				fontSize: 42,
    			captionSize: 12
			});
			$('.counter2').counter({
				val: {{$participant}},
			});
		});
		
	</script>
@elseif( Request::is('banner') )
	<script type="text/javascript">
		$(document).ready(function() {
			new Clipboard('.btn');
		});
	</script>
    <script src="{{ asset('js/system-js/registration.js') }}"></script>
    <script src="{{ asset('js/plugins/clipboard/clipboard.min.js') }}"></script>
@endif
@include('layouts.front-page.modal')

@if(Auth::check())
	<div id="seo-edit-navbar" class="nav navbar-seo-default">
	    <div class="container-fluid">
	        <ul class="nav navbar-nav">
	            <li>
	            	<a href="@if(Auth::user()->account_id !='4')/system/admin @else/system/support @endif" title="Go to Dashboard">
		            	<strong>
		            		<i class="fa fa-dashboard"></i> {{ $site_identity->site_title }}
		            	</strong>
	            	</a>
	            </li>
	        </ul>
	        <ul class="nav navbar-nav seo-admin-secondary">
	        	<li class="dropdown">
	        		<a href="@#" class="dropdown-toggle" id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        				<strong>
		                    @if(!empty(Auth::user()->display_name))
		                      {{ Auth::user()->display_name }} 
		                    @else
		                      {{ Auth::user()->first_name }} {{ Auth::user()->last_name }}
		                    @endif
        				</strong>
	        		</a>
        			<ul class="block m-t-xs dropdown-menu" aria-labelledby="dropdownMenu2">
        				
        				<li class="dropdown-item">
        					<a  href="{{ url( '/system/profile' ) }}">
		        				<strong>
		        					<i class="fa fa-user"></i>
				                    @if(!empty(Auth::user()->display_name))
				                    	{{ Auth::user()->display_name }} 
				                    @else
				                    	{{ Auth::user()->first_name }} {{ Auth::user()->last_name }}
				                    @endif
		        				</strong>
        					</a>
        				</li>
        				<li class="dropdown-item">        					
				            <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
				            	<strong><i class="fa fa-sign-out"></i> Logout</strong>
				            </a>
				            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">{{ csrf_field() }}</form>
        				</li>
        			</ul>
	        	</li>
	        </ul>
	    </div>
	</div>
@endif