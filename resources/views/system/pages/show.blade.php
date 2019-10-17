@extends('layouts.master')
@section('title', $site_identity->site_title.' | '.ucfirst(substr(Route::currentRouteName(),6)).' Pages')
@section('breadcrumb') 
   
            <h2><i class="fa fa-files-o"></i> Pages</h2>
            <ol class="breadcrumb">
                   <li>
                        <a href="@if(Auth::user()->account_id !='4' ) /system/admin @else/system/support  @endif ">Dashboard</a>
                   </li>
                   <li class="active">
                       <a href="/system/pages">Pages</a>
                   </li>
                    <li class="active">
                        <strong>{{ucfirst(substr(Route::currentRouteName(),6))}}</strong>
                    </li>
            </ol>

@endsection
@section('admin-content')
            <div class="wrapper wrapper-content clearfix">
                <div class="col-lg-12 ">
                    <h2>Compare Revisions of   {{ $page->page_title }}</h2>
                    <a href="{{'/system/pages/'.$page->pagesid.'/edit'}}" class="btn btn-sm btn-default" style="margin-bottom: 15px;"><i class="fa fa-angle-double-left"></i> Back to Editor</a>
                </div>
                <div class="col-lg-12">
                    <div class="ibox float-e-margins">
                        <div class="ibox-content">
                                <div class="form-group">
                                    <span> Current Revision By </span>
                                    <strong>{{$page->display_name}}</strong>  
                                </div>
                                <div class="form-group">
                                    <span> At </span>  
                                    <strong>{{$page->updated_at->format('M d, Y @ H:i')}}</strong>
                                </div>
                        </div>
                    </div> <!---.ibox-->
                    
                     <div class="ibox float-e-margins">
                        <div class="ibox-content">
                          <div class="titlecomp">
                            <h3>Title</h3>
                            <hr>
                                <div class="col-lg-4">
                                    <h4>Latest Title</h4>
                                    <div id="titleorg">{{ $page->page_title }}</div>
                                     <textarea class="form-control diff-textarea sr-only" name="org-ttl" rows="5" id="org-ttl">{!!htmlentities($page->page_title)!!}</textarea> 
                                </div>
                                <div class="col-lg-4">
                                    <h4>Recent Title</h4>
                                    <div id="titlerct">{{ $page->page_recent_title }}</div>
                                    <textarea class="form-control diff-textarea sr-only" name="rct-ttl" rows="5" id="rct-ttl">{!!htmlentities($page->page_recent_title)!!}</textarea> 
                                </div>     
                                <div class="col-lg-4">
                                    <h4>Different of Title</h4>
                                    <div class="diffresulttitle"></div>
                                </div>     
                            </div>
                            
                            <div class="contentcomp">
                            <h3>Content</h3>
                            <hr>
                            <div class="col-lg-4">
                                <h4>Latest Content</h4>
                                <div id="contorg">{!!html_entity_decode($page->page_content)!!}</div>
                                <textarea class="form-control diff-textarea sr-only" name="org-cont" rows="5" id="org-cont">{!!htmlentities($page->page_content)!!}</textarea> 
                            </div>
                            <div  class="col-lg-4">
                                <h4>Recent Content</h4>
                                <div id="contrct">{!!html_entity_decode($page->page_recent_content)!!}</div>
                                <textarea class="form-control diff-textarea sr-only" name="rct-cont" rows="5" id="rct-cont" >{!!htmlentities($page->page_recent_content)!!}</textarea> 
                            </div>    
                            <div  class="col-lg-4">
                                <h4>Different of Content</h4>
                                <div class="diffresult"></div>
                            </div>  
                            </div>    
                        </div>
                    </div> <!---.ibox-->
                </div> <!---.col-lg-12-->
            </div> <!---.wrapper-->
@endsection