@extends('layouts.front')

@section('front-title',  ucfirst($site_identity->site_title).' |  Reward')

@section('front-content')
    <div class="container">
        <div class="c-panel panel-seo-fun m-t-md panel-seo-ranking">
            <div class="c-panel-box c-panel-box-g c-panel-shadows">
                <h3 class="panel-title">HADIAH</h3>    
            </div>
            <div class="panel-seo-body c-panel-box clearfix" style="padding-top:0; padding-bottom: 0;">
                <!--<div class="table-responsive">-->
                <!--    <table class="table table-hover table-liga">-->
                <!--        <thead class="thead-liga">-->
                <!--            <tr></tr>-->
                <!--        </thead>-->
                <!--        <tbody>-->
                <!--            @if(!empty($reward)>0)-->
                <!--                @foreach ($reward as $rewards)-->
                <!--                    <tr class="gradeX table-item">-->
                                       
                <!--                        <td>JUARA {{$rewards->placereward}}</td>-->
                <!--                        <td>{{$rewards->amount}}</td>-->
                <!--                    </tr>-->
                <!--                @endforeach-->
                <!--            @else-->
                <!--                <tr class='gradeX'>-->
                <!--                    <td colspan='4' align="center"><strong>No Record Found</strong></td>-->
                <!--                </tr>-->
                <!--            @endif -->
                <!--        </tbody>-->
                <!--    </table> -->
                <!--</div>-->
			<div class="col-md-6 col-md-offset-3">
				<ul class="timeline">
	
				@if(!empty($reward))
					@php $i = 1 @endphp
				

					@foreach ($reward as $rewards)	
						
						@if($i < 4)
							@php  $badge_icon = "fa-trophy"; @endphp 
						@else
							@php  $badge_icon = "fa-star"; @endphp
						@endif	
						
						@php
						  $even = array(0, 2, 4, 6, 8);
						  if(in_array(substr($i, -1),$even)){
							$inverted = 'class=timeline-inverted';
						  }else{
							$inverted = '';
						  }
						@endphp 
				
						@php
						  if($i==1){
							$badgecolor = 'gold';
						  }elseif($i==2){
							$badgecolor = 'silver';
						  }elseif($i==3){
							$badgecolor = 'bronze';	
						  }elseif($i==4){
							$badgecolor = 'primary';
						  }elseif($i==5){
							$badgecolor = 'info';
						  }elseif($i==6){
							$badgecolor = 'success';			
						  }elseif($i==7){
						  	$badgecolor = 'danger';
						  }else{
							$badgecolor = '';
						  }
						@endphp 

						<li {{ $inverted }}>
						  <div class="timeline-badge {{$badgecolor}}"><i class="fa {{@$badge_icon}}"></i></div>
						  <div class="timeline-panel" style="background:#fff">
						    <div class="timeline-heading {{$badgecolor}}">
						      <h4 class="timeline-title text-center">JUARA {{$rewards->placereward}}</h4>
						    </div>
						    <div class="timeline-body text-center">
						      <p style="color:#b7873b;font-weight:600;">{{$rewards->amount}}</p>
						    </div>
						  </div>
						</li>

						@php $i++; @endphp
					@endforeach
				
				@endif


				</ul>
			</div>
            </div>
        </div>

    </div>
@endsection
