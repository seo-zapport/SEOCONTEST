@if(session()->has('message'))
<div class="alert alert-success alert-dismissable">
		<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
		{{session()->get('message')}}
</div>
@endif



