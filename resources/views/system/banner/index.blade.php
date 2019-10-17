@extends('layouts.master')
@section('title', $site_identity->site_title.' | Banner')
@section('breadcrumb')
          <h2><i class="fa fa-picture-o"></i> Banner</h2>
            <ol class="breadcrumb">
                   <li>
                        <a href="@if(Auth::user()->account_id !='4' ) /system/admin @else/system/support  @endif ">Dashboard</a>
                   </li>
                   <li class="active">
                       <strong>Banner</strong>
                   </li>
            </ol>
@endsection
@section('admin-content')
  <div class="wrapper wrapper-content clearfix">
    <div id="alert_box" class="col-lg-12 ">  @include('layouts.messages.messages') </div>
    
    <a href="{{'/system/banner/create'}}" class="btn btn-md btn-primary" style="margin-bottom: 15px;"><i class="fa fa-plus"></i> Add New</a>
    <div class="ibox">
      <div class="ibox-title">
        <h5>Banner List</h5>
      </div>
      <div class="tabs-container ibox-content">
              <div id="Banner-Items">
                  <div class="row">
                      <div class="col-lg-6">
                          <div class="status">
                              <ul class="nav">
                                 <li @if (app('request')->input('status_id')=='') class="active" @endif><a href="{{ url( '/system/banner' ) }}">All (@if($cseo_count==null){{0}}@else{{$cseo_count->countAll}}@endif)</a></li>
                                   <li @if (app('request')->input('status_id')=='9') class="active" @endif><a href="{{ url( '/system/banner?status_id=9' ) }}">Published (@if($cseo_count==null){{0}}@else{{$cseo_count->countPublished}}@endif)</a></li>
                                  <li @if (app('request')->input('status_id')=='10') class="active" @endif><a href="{{ url( '/system/banner?status_id=10' ) }}">Unpublished (@if($cseo_count==null){{0}}@else{{$cseo_count->countUnpublished}}@endif)</a></li>
                                  <li @if (app('request')->input('status_id')=='11') class="active" @endif><a href="{{ url( '/system/banner?status_id=11' ) }}">Trash (@if($cseo_count==null){{0}}@else{{$cseo_count->countTrash}}@endif)</a></li> 
                              </ul>
                          </div>
                      </div> <!---.col-lg-12-->
                      <div class="col-md-3 pull-right">
                          <!-- Search box  -->        
                          <form role="form" class="form-horizontal pull-right"  method="get" >
                              <div class="input-group">
                                  <div class="input-group-btn">
                                      <button id="searchnow" type="submit" class="btn btn-primary searchnow"> Search </button>
                                  </div>
                                  <input type="text" class="form-control" id="search" name="search" placeholder="Search for ...">
                                  @if(!empty(app('request')->input('status_id')))  
                                      <input type="hidden" id="status_id" name="status_id" value="{{app('request')->input('status_id')}}"> 
                                  @endif
                              </div>
                          </form>
                      </div> 
                  </div> <!---.row-->
                  <div class="row">
                      <div class="col-md-5">
                          <form role="form" class="form-horizontal col-lg-5" method="post"> 
                              {{csrf_field()}}         
                              <div class="form-group">
                                  <div class="input-group">
                                      <select class="form-control m-b" id="bulkAction" name="bulkAction" required autofocus>
                                          <option value=""> -Bulk Action- </option>
                                      </select> 
                                      <div class="input-group-btn">
                                          <button id="btn-bulkActionBanner" type="button" class="btn btn-m btn-success btn-bulkActionBanner">Apply</button>
                                      </div>
                                  </div>
                              </div>
                          </form>
                      </div>
                      <div class="col-md-3 pull-right">
                          <p class="badge badge-info"><span>{{ @$banner_count }}</span> Item(s)</p>
                            @if(!empty(app('request')->input('search')))  
                               Search results for <strong>"{{app('request')->input('search')}}"</strong>
                           @endif 
                      </div>
                  </div> <!---.row-->
                  <div class="table-responsive" id="data_slider_table">
                      <table class="table table-striped table-bordered table-hover" >
                          <thead>
                              <tr>
                                  <th class="text-center">
                                  <div class="checkbox checkbox-primary">
                                      <input type="checkbox" class="styled styled-primary" id="selectAll" name="selectAll">
                                      <label></label>
                                  </div>
                                  </th>
                                  <th>Banner</th>
                                  <th>Title</th>
                                  <th>Merchant</th>
                                  <th>Category</th>
                                  <th>Status</th>
                                  <th>Date</th>
                                  <th>Action</th>
                              </tr>
                          </thead>
                          <tbody>
                          @if(count($banner)> 0)
                              @foreach ($banner as $banners)
                                  <tr class="gradeX table-item">
                                      <td class="text-center">
                                        <div class="checkbox checkbox-primary rows">
                                            <input type="checkbox" class="styled styled-primary check" id="bannerarr" name="bannerarr[]" value="{{$banners->banner_id}}" >
                                            <label></label>
                                        </div>                           
                                      </td>
                                      <td style="width:20%;">
                                        <div class="slider-img-group">
                                          @if(!empty($banners->media_name))
                                            <div class="slider-img-list">
                                              <img src="{{'/img/gallery/'.$banners->media_name}}">
                                             </div>
                                          @else
                                            <div class="slider-img-list slider-placeholder">
                                              <img id="preview_images" src="http://via.placeholder.com/250x150" class="img-responsive">
                                            </div>
                                          @endif
                                        </div>
                                      </td>
                                      <td>
                                          <strong>{{ucfirst($banners->title_name)}}</strong>
                                      </td>
                                      <td>{{str_replace('http://', '', $banners->merchant_name)}}</td>
                                      <td>{{$banners->category_name}}</td>
                                      <td>{{$banners->status_name}}</td>
                                      <td>{{$banners->created_at->format('F d, Y')}}</td>
                                      <td>
                                          @if($banners->status_id == '11')
                                            <span><a href="#" class="modalRestore" data-hover="tooltip" data-placement="top"  data-toggle="modal"  data-target="#ViewStatus-{{$banners->banner_id}}" title="Restore"><button class="btn btn-success  dim" type="button"><i class="fa fa-refresh"></i></button><input type="hidden" id="Restoreid" name="Restoreid" value="{{$banners->banner_id}}"></a></span>
                                            |
                                            <span><a href="#" class="modalDelete" data-hover="tooltip" data-placement="top"  data-toggle="modal"  data-target="#ViewStatus-{{$banners->banner_id}}" title="Delete"><button class="btn btn-danger  dim" type="button"><i class="fa fa-trash"></button><i class="fa fa-2x fa-trash"></i><input type="hidden" id="Delid" name="Delid" value="{{$banners->banner_id}}"></a></span>
                                          @else
                                            <span><a href="{{'/system/banner/'.$banners->banner_id.'/edit'}}" class="text-info" title="Edit"><button class="btn btn-info  dim" type="button"><i class="fa fa-paste"></i> </button></a></span>
                                            <span><a href="#" class="modalTrash" data-hover="tooltip" data-placement="top"  data-toggle="modal"  data-target="#ViewStatus-{{$banners->banner_id}}" title="Move To Trash"><button class="btn btn-danger  dim" type="button"><i class="fa fa-trash"></i></button><input type="hidden" id="Trashid" name="Trashid" value="{{$banners->banner_id}}"></a></span>
                                          @endif

                                      </td>
                                  </tr>
                              @endforeach
                              @else
                              <tr class='gradeX'>
                                  <td colspan='8' align="center"><strong>No Record Found</strong></td>
                              </tr>
                          @endif       
                          </tbody>
                      </table>
                  </div> <!---.table-responsive-->
                  <div id="paginate" name="paginate">
                      {{ $banner->links() }}
                  </div>  
              </div> <!---#banner-Items-->
  </div>
</div>
</div>

  @if(count($banner)>0)
  @foreach ($banner as $banners)

    <div class="modal fade" id="ViewStatus-{{$banners->banner_id}}" tabindex="-1" role="dialog"  aria-hidden="true">
      <div class="modal-dialog modal-m">
        <div class="modal-content">
          <div class="modal-header bg-primary">
            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
            <h4 class="modal-title" id="modal-title">Delete Status</h4>
          </div>
          <div class="modal-body">
            <input type="hidden" id="banner_id" name="banner_id[]">
            <input type="hidden" id="status_now_{{$banners->banner_id}}" name="status_now" value="{{$banners->status_id}}">
            <input type="hidden" id="curr_status_{{$banners->banner_id}}" name="status_current" value="{{$banners->curr_status_id}}">

            <div class="container-fluid">
              <div class="col-lg-12 for-delete" style="display: none;">
                <form role="form" class="form-horizontal" >
                {{csrf_field()}}
                  <div class="form-group"><label>Do You want to Delete This Banner?</label></div>
                </form>   
              </div> 
              <div class="col-lg-12 for-restore" style="display: none;">
              <form role="form" class="form-horizontal" method="post">
              {{csrf_field()}}
              <div class="form-group"><label>Do You want to Restore This Banner?</label></div>
              </form>   
              </div> 
              <div class="col-lg-12 for-movetrash" style="display: none;">
                <form role="form" class="form-horizontal" method="post">
                {{csrf_field()}}
                  <div class="form-group"><label>Do You want to Trash This Banner?</label></div>
                </form>   
              </div>
            </div>
          </div>    
          <div class="modal-footer form-model-footer">
            <button type="button" id="cancel" class="btn btn-white" data-dismiss="modal">Cancel</button>
            <button type="button" id="deleteBanner" class="btn btn-danger deleteBanner" data-dismiss="modal">Delete</button>
            <button type="button" id="btn-moveActionBanner" class="btn btn-primary restoreBanner btn-moveActionBanner" data-dismiss="modal" data-id="{{$banners->banner_id}}" style="display: none;">Restore</button>
            <button type="button" id="btn-moveActionBanner" class="btn btn-danger trashBanner btn-moveActionBanner" data-dismiss="modal" data-id="{{$banners->banner_id}}" style="display: none;">Move to Trash</button>

          </div>

        </div>

      </div>

    </div>

  @endforeach 
  @endif


@endsection







                        