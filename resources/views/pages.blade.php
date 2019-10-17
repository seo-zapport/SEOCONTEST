@extends('layouts.front')

@section('front-title', ucfirst($site_identity->site_title).' | '.ucfirst($page->page_title)  )

@section('front-content')
    <div class="container">
        <div class="c-panel panel-seo-fun m-t-md">
            <div class="c-panel-box c-panel-box-g c-panel-shadows">
                <h3 class="panel-title">{{ucfirst($page->page_title)}}</h3>    
            </div>
            <div class="panel-seo-body c-panel-box">
                <div class="form-group">
                {!!html_entity_decode($page->page_content) !!} 

                @if (Auth::check())    
                <a href="{{ url('system/pages/' . $page->id. '/edit') }}" class="btn btn-link"> <i class="fa fa-edit"></i> Edit </a>
                @endif
                </div>
            </div>
        </div>
    </div>
@endsection