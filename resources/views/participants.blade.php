@extends('layouts.front')

@section('front-title',  ucfirst($site_identity->site_title))

@section('front-content')
	<section class="banner">
		<h2 class="sr-only">Banner Section</h2>
		<div class="container-fluid">
			<div class="row">
				{{-- <img src="{{ asset('/img/front-assets/funbet-banner.jpg') }}" class="img-responsive"> --}}
				@if(!empty($banner)) 
					<img src="{{ $banner->merchant_name.'/img/gallery/'.$banner->media_name }}" class="img-responsive">
				@else
					<img src="http://via.placeholder.com/2000x430" class="img-responsive">
				@endif
			</div>
		</div>
	</section>
	<section id="timepicker">
		<h2 class="sr-only">Time Picker</h2>
		<div class="container">
			<div class="flexwrap">
				<div id="limitsTimeWrap" class="col-xs-12 col-sm-12 col-md-6">
					<div class="col-xs-12 col-sm-12 col-md-11 col-xs-offset-0 col-sm-offset-0 col-md-offset-1 p-sm-r">		
						<h1 class="heading-3 sr-only">Limits of Registration</h1>
						<div class="timeImgWrap hidden-xs">
							<img src="{{ asset('/img/front-assets/counter1-img.png') }}" class="img-responsive">
						</div>
						<div class="clock-box">
							<div id="limitTimePicker"></div>
						</div>
					</div>
				</div>
				<div id="annTimeWrap" class="col-xs-12 col-sm-12 col-md-6 m-t">
					<div class="col-xs-12 col-sm-12 col-md-11 col-xs-offset-0 col-sm-offset-0 col-md-offset-1 p-sm-r">		
						<h1 class="heading-3 sr-only">Winner Announcement</h1>
						<div class="timeImgWrap hidden-xs">
							<img src="{{ asset('/img/front-assets/counter2-img.png') }}" class="img-responsive">
						</div>
						<div class="clock-box">
							<div id="announcementTimePicker"></div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
	<section id="contentArea" class="m-b">
		<h2 class="sr-only">Content area</h2>
		<div class="container">
			<div class="c-panel-box c-panel-box-g c-panel-shadows m-b-md">
				<h3 class="heading-3 text-center">@if(!empty($front_pages[0]->page_title)){{ $front_pages[0]->page_title }}@else{{str_replace('http://', '', URL::to('/'))}}@endif</h3>
			</div>
			<div class="c-panel-box db-bg t-left b-r">
				<div class="row">
					<div class="col-md-4">
						<div class="particpantWrap text-center">
							<p class="fun-shdows" data-text="Jumlah Peserta">Jumlah Peserta</p>
							<div class="jcpo-counter counter2"></div>
							<p class="fun-shdows" data-text="Peserta">Peserta</p>
						</div>
					</div>
					<div class="col-md-8">
						<div class="text-justify p-t p-b">
						    @if(!empty($front_pages[0]->page_content))
							{!! $front_pages[0]->page_content  !!}
							@else
							<p><strong>Lorem Ipsum</strong> is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>
							@endif
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
	<section id="banks" class="m-b">
		<h2 class="sr-only">The Winner</h2>
		<div class="container">
			<div class="c-panel panel-seo-fun">
				<div class="c-panel-box c-panel-box-g c-panel-shadows">
					<h3 class="heading-3 text-center">The Winners</h3>
				</div>
				<div class="panel-seo-body">
					    <table class="table table-hover table-liga">
					        <thead class="thead-liga">
					            <tr>
					                <th scope="col" class="text-center">#</th>
					                <th scope="col" class="text-center">NAMA PEMENANG</th>
					                <th scope="col" class="text-center">Url PEMENANG</th>
					                <th scope="col" class="text-center" >BUKTI PEMBAYARAN</th>
					            </tr>
					        </thead>
					        <tbody>

					                <tr class='gradeX'>
					                    <td colspan='4' align="center"><strong>No Record Found</strong></td>
					                </tr>

					        </tbody>
					    </table> 
					</div>
				</div>
			</div>
		</div>
	</section>
	<section id="formRegistration" class="m-b">
		<h2 class="sr-only">Form Participants Registrations</h2>
		<div class="container">
			<div class="c-panel-box c-panel-box-g c-panel-shadows m-b">
				<h3 class="heading-3 text-center">FORM PENDAFTARAN LOMBA KONTES SEO.</h3>
			</div>
			<form id="registrationForm" role="form">
				{{csrf_field()}}
				<div id="alert_box"> @include('layouts.messages.messages') </div>
				<div class="row m-b">
					<div class="col-md-6">
						<div class="c-panel panel-seo-fun m-b">
							<div class="c-panel-box c-panel-box-g c-panel-shadows">
								<h3 class="heading-3 text-center">DATA PRIBADI</h3>
							</div>
							<div class="panel-seo-body c-panel-box">
								<div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
									<label for="Name">Name (*)</label>
									<div class="bg-input">
										<input type="text" class="form-control" id="full_name" name="full_name" placeholder="Enter Name" value="{{ old('full_name') }}">
										@if($errors->has('name'))
											<span class="help-block"><strong class="text-danger">{{ $errors->first('name') }}</strong></span>
										@endif
									</div>
								</div>
								<div class="form-group {{ $errors->has('email') ? 'has-error' : '' }}" id="sample">
									<label for="Email">Email (*)</label>
									<div class="bg-input">
										<input type="email" class="form-control" id="email" name="email" placeholder="Enter Email" value="{{ old('email') }}">
										@if($errors->has('email'))
											<span class="help-block"><strong class="text-danger">{{ $errors->first('email') }}</strong></span>
										@endif
									</div>
								</div>
								<div class="form-group {{ $errors->has('mob_no') ? 'has-error' : '' }}">
									<label for="Mobile No">Mobile No (*)</label>
									<div class="bg-input">
										<input type="number" class="form-control" id="mob_no" name="mob_no" placeholder="Enter Mobile No" value="{{ old('mob_no') }}">
										@if($errors->has('mob_no'))
											<span class="help-block"><strong class="text-danger">{{ $errors->first('mob_no') }}</strong></span>
										@endif
									</div>
								</div>
								<div class="form-group {{ $errors->has('url_permalink') ? 'has-error' : '' }}">
									<label for="url_permalink">Web Url Entry (*)</label>
									<div class="bg-input">
										<input type="text" class="form-control" id="url_permalink" name="url_permalink" placeholder="Enter Url Entry" value="{{ old('url_permalink') }}">
										@if($errors->has('url_permalink'))
											<span class="help-block"><strong class="text-danger">{{ $errors->first('url_permalink') }}</strong></span>
										@endif
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col-md-6">
						<div class="c-panel panel-seo-fun m-b">
							<div class="c-panel-box c-panel-box-g c-panel-shadows">
								<h3 class="heading-3 text-center">DATA BANK</h3>
							</div>
							<div class="panel-seo-body c-panel-box">
								<div class="form-group {{ $errors->has('bank_name') ? 'has-error' : '' }}">
									<label for="bank_name">Your Bank Name</label>
									<div class="bg-input">
										<select class="form-control valid" id="bank_name" name="bank_name" required="" autofocus="" aria-invalid="false">
											<option >-Select Bank Type-</option>
											@foreach ($bank as $banks) 
												<option value="{{$banks->id}}" {{ ( collect( old('bank_name') )->contains($banks->id) ) ? 'selected' : '' }} >{{$banks->name}}</option>
											@endforeach
										</select> 
										@if($errors->has('bank_name'))
											<span class="help-block"><strong class="text-danger">{{ $errors->first('bank_name') }}</strong></span>
										@endif
									</div>
								</div>
								<div class="form-group {{ $errors->has('acct_no') ? 'has-error' : '' }}">
									<label for="acct_no">Your Account Number</label>
									<div class="bg-input">
										<input type="text" class="form-control" id="acct_no" name="acct_no" placeholder="Your Account Number" value="{{ old('acct_no') }}"> 
										@if($errors->has('acct_no'))
											<span class="help-block"><strong class="text-danger">{{ $errors->first('acct_no') }}</strong></span>
										@endif
									</div>
								</div>
								<div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
									<label for="bo_acct">On behalf of the Account</label>
									<div class="bg-input">
										<input type="text" class="form-control" id="be_acct" name="be_acct" placeholder="On behalf of the Account" value="{{ old('be_acct') }}"> 
										@if($errors->has('be_acct'))
											<span class="help-block"><strong class="text-danger">{{ $errors->first('be_acct') }}</strong></span>
										@endif
									</div>
								</div>
							</div>
						</div>
						<div class="c-panel panel-seo-fun">
							<div class="c-panel-box c-panel-box-g c-panel-shadows">
								<h3 class="heading-3 text-center">VALIDISI</h3>
							</div>
							<div class="panel-seo-body c-panel-box">
								<p>I have read and understand the rules of this seo contest and are willing to comply with this Regulation without exception</p>
							    <div class="g-recaptcha" data-callback="onloadCallback" data-sitekey="{{$title->data_sitekey}}"></div> 
								<div id="btnWrap" class="text-center m-t">
								     <input type="button" id="btnRegister" class="btn btn-success btn-lg btn-validation" style="display:none;" value="Sign Up Now">
								</div>
							</div>
						</div>
					</div>
				</div>
			</form>
		</div>
	</section>
	<section id="seoWrap" class="m-b">
		<h2 class="sr-only">Seo Ranking</h2>
		<div class="container">
			<div class="c-panel panel-seo-fun">
				<div class="c-panel-box c-panel-box-g c-panel-shadows">
					<h3 class="heading-1 text-center">SEO Ranking</h3>
				</div>
				<div class="panel-seo-body">
					<p class="text-center">JURI DALAM LOMBA KONTES SEO INI ADALAH GOOGLE ( dengan lokasi indonesia / google.co.id).</p>
					<p class="text-center">Dengan membersihkan history serta cookies terlebih dahulu.</p>
					<a class="seo-link" href="{{$team->google}}/search?search&q={{str_replace(" ","+",$title->ranking)}}" target="_blank">
						<img src="{{ asset('/img/front-assets/googleBtn.png') }}" class="img-responsive">
					</a>
				</div>
			</div>
		</div>
	</section>
@endsection