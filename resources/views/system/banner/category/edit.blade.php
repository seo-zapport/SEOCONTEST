@extends('layouts.pages')

@section('title', $site_identity->site_title.' | Banner')


@section('header-title')
    SlideShow
@endsection


@section('breadcrumb')
   <li>
        <a href="/">Home</a>
    </li>
    <li class="active">
        <a href="/slider/slideshow/">Slideshow</a>
    </li>
    <li class="active">
        <strong>EDIT</strong>
    </li>
@endsection



@section('body')
	        <div class="col-lg-12 center">
               <div class="row">
                <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Edit SlideShow</h5>
                    </div>
                    <div class="ibox-content">
                               
                                <form role="form" class="form-horizontal" action="{{'/slider/category/'.$slideshow->id}}" method="post">
                                {{csrf_field()}}
                                {{method_field('PUT')}}
                                    <div class="form-group"><label>Name</label> <input type="text" name='category_name' placeholder="Name" class="form-control" value="{{$slideshow->category_name}}"></div>
                                    <div class="form-group"><label>Description</label> <textarea name='description' rows="10" placeholder="Description" class="form-control" >{{$slideshow->description}}</textarea> </div>    
                                    <div class="form-group"><button class="btn btn-sm btn-primary pull-left m-t-n-xs" type="submit"  ><strong>Submit</strong></button>  </div>          
   
                                </form> 
                              
                    </div>

                        @include('layouts.messages.errors')

                </div>
            </div>
            </div>
            </div>



@endsection



 						