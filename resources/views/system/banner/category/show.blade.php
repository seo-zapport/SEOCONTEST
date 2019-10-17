@extends('layouts.app')

@section('title', $site_identity->site_title.' | Banner')

@section('Breadcrum')
    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-sm-4">
            <h2><i class="fa fa-list"></i> Slideshow</h2>
            <ol class="breadcrumb">
                   <li>
                        <a href="@if(Auth::user()->account_id =='1')/system/admin @else/system/user @endif">Dashboard</a>
                   </li>
                   <li>
                       <a href="/backoffice/slider/category">Category</a>
                   </li>
                   <li class="active">
                       <strong>Slideshow</strong>
                   </li>
            </ol>
        </div>

    </div>
@endsection


@section('content')

    <div class="row">
         <div class="col-lg-12">
             <div class="wrapper wrapper-content">
                    <a href="{{ URL::previous() }}" class="btn btn-sm btn-success" style="margin-bottom: 15px;"><i class="fa fa-arrow-circle-left"></i> Go Back</a>            
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                         @foreach ($title as $titles) 
                          <h5>{{$titles->category_name}}</h5>
                         @endforeach  
                        </div>
                        
                        <div class="ibox-content ">

                        @if(count($slides)>0)
                            <div class="carousel slide" id="carousel2">
                              <ol class="carousel-indicators">
                               @foreach ($slides as $slide)
                                      <li data-slide-to="{{ $loop->index }}" data-target="#carousel2"  class="{{ $loop->first ? 'active' : '' }}"></li>
                                @endforeach             
                                </ol>
                                   <div class="carousel-inner">
                                         @foreach ($slides as $slide) 
                                            <div class="item {{ $loop->first ? 'active' : '' }}">
                                                <img alt="{{$slide->media_name}}"  class="img-responsive" src="{{asset('/img/gallery/'.$slide->media_name)}}">
                                                <div class="carousel-caption">
                                                    <p>{{$slide->title_name}}</p>
                                                </div>
                                            </div>
                                         @endforeach       
                                      </div>
                                      
                                <a data-slide="prev" href="#carousel2" class="left carousel-control">
                                    <span class="icon-prev"></span>
                                </a>
                                <a data-slide="next" href="#carousel2" class="right carousel-control">
                                    <span class="icon-next"></span>
                                </a>
                            </div>
                         @else
                                  <h1 align="center">No Slider Selected</h1>
                         @endif
                        </div>
                    </div>
             </div>
         </div>
    </div>


@endsection



