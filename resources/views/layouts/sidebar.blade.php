	<nav class="navbar-default navbar-static-side" role="navigation">

		<div class="sidebar-collapse">

			<ul class="nav metismenu" id="side-menu">

				<li class="nav-header">

					<div class="dropdown profile-element">

			   <!-- <span><img alt="image" class="img-circle" src="/img/profile_small.jpg" /></span> -->

					    @php                            
					        if (!empty(Auth::user()->media[0]->media_name)) {
					            $media_img = Auth::user()->media[0]->media_name;
					        }else{
					            $media_img = 'profile.png';
					        }
					    @endphp

					    <span><img alt="image" class="img-circle" src="/img/accounts/{{$media_img}}" /></span>
					    <a data-toggle="dropdown" class="dropdown-toggle" href="/#">
					        <span class="clear"> 
					                 <span class="block m-t-xs"> <strong class="font-bold">
					                    @if(!empty(Auth::user()->display_name))
					                      {{ Auth::user()->display_name }} 
					                    @else
					                      {{ Auth::user()->first_name }} {{ Auth::user()->last_name }}
					                    @endif
					                 </strong></span>

					                 <span class="text-muted text-xs block">

					                 @if(Auth::user()->position=="") 
					                    {{Auth::user()->status[0]->status_name}}
					                 @else
					                    {{Auth::user()->position}}
					                 @endif 
					                 <b class="caret"></b></span> 
					        </span>
					         </a>

					    <ul class="dropdown-menu animated fadeInRight m-t-xs">
					        <li><a href="{{ url( '/system/profile' ) }}">Profile</a></li>
					    </ul>
					</div>

					<div class="logo-element">
						Seo Contest
					</div>
				</li>

				<li @if (Request::is('system/admin') || Request::is('system/developer') || Request::is('system/support') )class="active"@endif>
					<a href="{{ url('/system') }}@if(Auth::user()->account_id !='4' )/admin @else/support @endif"><i class="fa fa-th-large"></i> <span class="nav-label">Dashboard</span></a>
				</li>

				@if(Auth::user()->account_id !='2' )

				<li @if (Request::is('system/pages') || Request::is('system/pages/*'))class="active"@endif>
					<a href="{{ url('/system/pages') }}"><i class="fa fa-file-o"></i> <span class="nav-label">Pages</span><span class="fa arrow"></span></a>
					<ul class="nav nav-second-level collapse">
						<li @if (Request::is('system/pages'))class="active"@endif ><a href="{{ url('/system/pages') }}">All Pages</a></li>
						<li @if (Request::is('system/pages/*'))class="active"@endif ><a href="{{ url('/system/pages/create') }}">Add New</a></li>
					</ul>
				</li>
				
				<li @if (Request::is('system/media') || Request::is('system/media/*'))class="active"@endif>
					<a href="{{ url('/system/media') }}"><i class="fa fa-camera"></i> <span class="nav-label">Media</span><span class="fa arrow"></span></a>
					<ul class="nav nav-second-level collapse">
						<li @if (Request::is('system/media'))class="active"@endif><a href="{{ url('/system/media') }}">Library</a></li>
						<li @if (Request::is('system/media/create'))class="active"@endif><a href="{{ url('/system/media/create') }}">Upload</a></li>
					</ul>
				</li>

				<li @if (Request::is('system/banner') || Request::is('system/banner/*'))class="active"@endif>
					<a href="{{ url('/system/banner') }}"><i class="fa fa-picture-o"></i> <span class="nav-label">Banner</span><span class="fa arrow"></span></a>
					<ul class="nav nav-second-level collapse">
						<li @if (Request::is('system/banner'))class="active"@endif><a href="{{ url('/system/banner') }}">Library</a></li>
						<li @if (Request::is('system/banner/create'))class="active"@endif><a href="{{ url('/system/banner/create') }}">Add New Banner</a></li>
						<li @if (Request::is('system/banner/category'))class="active"@endif><a href="{{ url('/system/banner/category') }}">Category</a></li>
					</ul>
				</li>
				@endif
				
				<li @if (Request::is('system/contest'))class="active"@endif>
					<a href="{{ url('/system/contest') }}"><i class="fa fa-list"></i> <span class="nav-label">Contestant</span></a>
				</li>

				<li @if (Request::is('system/winner') || Request::is('system/winner/*'))class="active"@endif>
					<a href="{{ url('/system/winner') }}"><i class="fa fa-star"></i> <span class="nav-label">Winner</span></a>
					<ul class="nav nav-second-level collapse">
						<li @if (Request::is('system/winner'))class="active"@endif><a href="{{ url('/system/winner') }}">Library</a></li>
						<li @if (Request::is('system/winner/create'))class="active"@endif><a href="{{ url('/system/winner/create') }}">Add New Winner</a></li>
					</ul>
				</li>
				
				@if(Auth::user()->account_id !='2')
				<li @if (Request::is('system/menu') || Request::is('system/menu/*')  || Request::is('system/theme-settings') || Request::is('system/theme-settings/*') )class="active"@endif>
					<a href="#"><i class="fa fa-paint-brush"></i> <span class="nav-label">Appearance</span><span class="fa arrow"></span></a>
					<ul class="nav nav-second-level collapse">
						@if(Auth::user()->account_id =='1' || Auth::user()->account_id =='3')
						<li @if (Request::is('system/theme-settings') || Request::is('system/theme-settings/*'))class="active"@endif><a href="{{ url('system/theme-settings') }}">Theme Settings</a></li>
						@endif 
						@if(Auth::user()->account_id !='2')
						<li @if (Request::is('system/menu') || Request::is('system/menu/*') )class="active"@endif><a href="{{ url('/system/menu') }}">Menu</a></li>
						@endif 
					</ul>
				</li>
				@endif 	
				
				<li @if (Request::is('system/reward') || Request::is('system/reward/*'))class="active"@endif>
					<a href="{{ url('/system/reward') }}"><i class="fa fa fa-trophy"></i> <span class="nav-label">Reward</span></a>
				</li>

				@if(Auth::user()->account_id !='4' )

				<li @if (Request::is('system/account') || Request::is('system/account/*'))class="active"@endif>
					<a href="{{ url('/system/account') }}"><i class="fa fa-user"></i> <span class="nav-label">Users</span><span class="fa arrow"></span></a>
					<ul class="nav nav-second-level collapse">
						<li @if (Request::is('system/account'))class="active"@endif><a href="{{ url('/system/account') }}">All Users</a></li>
						<li @if (Request::is('system/account/*'))class="active"@endif><a href="{{ url('/system/account/create') }}">Add New</a></li>
					</ul>
				</li>

				@endif

				<li @if (Request::is('system/settings-general') || Request::is('system/merchant'))class="active"@endif>
					<a href="{{ url('/system/settings-general') }}"><i class="fa fa-gear"></i> <span class="nav-label">Settings</span><span class="fa arrow"></span></a>
					<ul class="nav nav-second-level collapse">	
						@if(Auth::user()->account_id =='4')	
						<li @if (Request::is('system/settings-general'))class="active"@endif><a href="{{ url('/system/settings-general') }}">General</a></li>
					    @endif
						@if(Auth::user()->account_id !='4')
						<li @if (Request::is('system/merchant'))class="active"@endif><a href="{{ url('/system/merchant') }}">Merchant</a></li>
						<li @if (Request::is('system/bank'))class="active"@endif><a href="{{ url('/system/bank') }}">Bank</a></li>
						@endif
					</ul>
				</li>

		

			</ul>

		</div>

	</nav>

