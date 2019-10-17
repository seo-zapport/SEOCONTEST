@extends('layouts.front')

@section('front-title',  ucfirst($site_identity->site_title).' |  Banners')

@section('front-content')
    <div class="container">
        <div class="c-panel panel-seo-fun m-t-md panel-seo-ranking">
            <div class="c-panel-box c-panel-box-g c-panel-shadows">
                <h3 class="panel-title">Banner</h3>    
            </div>
            <div class="panel-seo-body c-panel-box banner clearfix">
              @if(count($category)>0)

                <ul class="nav nav-pills">
                    @foreach($category as $cat)
                      <li @if($loop->first) class='active' @endif ><a data-toggle="pill" href="#{{str_replace(' ','',$cat->category_name)}}">{{$cat->category_name}}</a></li>
                    @endforeach
                </ul>
              
            <div class="tab-content clearfix">
            
                @foreach($category as $cat)
                  <div id="{{str_replace(' ','',$cat->category_name)}}" class="tab-pane fade in @if($loop->first) active @endif">
                    <div class="row">
                        @foreach($banner as $ban)
                         @if($ban->cseo_categories_id == $cat->id) 
                            @if(count($ban)>0)
                                  <div class="col-md-4 form-group">
                                      <div class="banner-panel panel panel-primary">
                                        <div class="banner-heading panel-heading text-center">
                                          <h2 class="heading-3">{{ $ban->title_name }}</h2>
                                        </div>
                                        <div class="banner-body panel-body">
                                          <img class="first-slide img-responsive mar-auto" src="{{asset('/img/gallery/'.$ban->media_name)}}" alt="{{$ban->media_name}}" >
                                        </div>
                                        <div class="banner-footer panel-footer">
                                          <div class="area-copy"> 
                                            <pre id="copytext-{{$ban->banid}}">&lt;p style=&quot;text-align:center;&quot;&gt;&lt;a href=&quot;{{$ban->target_url}}&quot; target=&quot;_blank&quot;&gt;&lt;img src=&quot;{{asset('/img/gallery/'.$ban->media_name)}}&quot; title=&quot;{{$ban->title_banner}}&quot; alt=&quot;{{$ban->alt_text_banner}}&quot;/&gt;&lt;/a&gt;&lt;/p&gt;</pre>
                                            <span class="input-group-button">
                                              <button class="btn btn-danger" data-clipboard-target="#copytext-{{$ban->banid}}"><i class="fa fa-copy"></i> Copy</button>
                                            </span>
                                          </div>
                                        </div>
                                      </div>
                                  </div>
                              @else
                                <h2 class="text-center">No Banner Upload Yet</h2>
                              @endif 
                          @endif 
                        @endforeach
                    </div>
                  </div>
                @endforeach
              @else
                  <h2 class="text-center">No Banner Upload Yet</h2>
              @endif


            </div>
        </div>
    </div>
@endsection
{{--

728x90
120x600
250x250 --}}