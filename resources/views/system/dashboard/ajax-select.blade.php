<option value="">--- Select Merchant ---</option>
@if(!empty($domain))
@foreach ($domain as $domains)  
<option value="{{$domains->id }}" class="text-center">{{str_replace('http://','',$domains->merchant_name)}}</option>
@endforeach
@endif