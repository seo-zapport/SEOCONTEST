@php 
if(!empty($merchant)){
$search = str_replace('http://','',"search=".$merchant->merchant_name."&");
}else{
$search = "";
}
@endphp

<div class="col-lg-4">
    <div class="widget yellow-bg">
        <div class="row">
            <div class="col-xs-4">
                <i class="fa fa-clock-o fa-5x"></i>
            </div>
            <div class="col-xs-8 text-right">
                <h2><a href="{{url('system/contest?'.$search.'status_id=6')}}" class="text-primary default-link">Pending</a></h2>
                <h2 class="font-bold">@if(count($status_register)>0) <a href="{{url('system/contest?'.$search.'status_id=6')}}" class="text-primary default-link">{{ $status_register->countPending }}</a> @else 0 @endif</h2>
                <small>Total pending</small>
            </div>
        </div>
    </div>
</div>

<div class="col-lg-4">
    <div class="widget red-bg">
        <div class="row">
            <div class="col-xs-4">
                <i class="fa fa-times fa-5x"></i>
            </div>
            <div class="col-xs-8 text-right">
                <h2><a href="{{url('system/contest?'.$search.'status_id=8')}}" class="text-primary default-link">Disqualified</a></h2>
                <h2 class="font-bold">@if(count($status_register)>0) <a href="{{url('system/contest?'.$search.'status_id=8')}}" class="text-primary default-link">{{ $status_register->countDisqual }}</a> @else 0 @endif</h2>
                <small>Total Disqualified</small>
            </div>
        </div>
    </div>
</div>

<div class="col-lg-4">
    <div class="widget navy-bg">
        <div class="row">
            <div class="col-xs-4">
                <i class="fa fa-check fa-5x"></i>
            </div>
            <div class="col-xs-8 text-right">
                <h2><a href="{{url('system/contest?'.$search.'status_id=7')}}" class="text-primary default-link"> Approved </a></h2>
                <h2 class="font-bold">@if(count($status_register)>0) <a href="{{url('system/contest?'.$search.'status_id=7')}}" class="text-primary default-link">{{ $status_register->countApproved }}</a> @else 0 @endif</h2>
                <small>Total Approved</small>
            </div>
        </div>
    </div>
</div>



{{-- </div>
</div> --}}