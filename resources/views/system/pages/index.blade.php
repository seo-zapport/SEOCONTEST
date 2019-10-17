@extends('layouts.master')
@section('title', $site_identity->site_title.' | Pages')
@section('breadcrumb')
          <h2><i class="fa fa-files-o"></i> Pages</h2>
            <ol class="breadcrumb">
                   <li>
                      <a href="@if(Auth::user()->account_id !='4' ) /system/admin @else/system/support  @endif ">Dashboard</a>
                   </li>
                   <li class="active">
                       <strong>Pages</strong>
                   </li>
            </ol>
@endsection
@section('admin-content')
  <div class="wrapper wrapper-content clearfix">
    <div id="alert_box" class="col-lg-12 ">  @include('layouts.messages.messages') </div>
    <a href="{{'/system/pages/create'}}" class="btn btn-md btn-primary" style="margin-bottom: 15px;"><i class="fa fa-plus"></i> Add New</a>
    <div class="ibox">
      <div class="ibox-title">
        <h5>Page List</h5>
      </div>
      <div class="tabs-container ibox-content">
              <div id="Pages-Items">
                  <div class="row">
                      <div class="col-lg-6">
                          <div class="status">
                              <ul class="nav">
                                 <li @if (app('request')->input('status_id')=='') class="active" @endif><a href="{{ url( '/system/pages' ) }}">All (@if($cseo_count==null){{0}}@else{{$cseo_count->countAll}}@endif)</a></li>
                                   <li @if (app('request')->input('status_id')=='9') class="active" @endif><a href="{{ url( '/system/pages?status_id=9' ) }}">Published (@if($cseo_count==null){{0}}@else{{$cseo_count->countPublished}}@endif)</a></li>
                                  <li @if (app('request')->input('status_id')=='12') class="active" @endif><a href="{{ url( '/system/pages?status_id=12' ) }}">Draft (@if($cseo_count==null){{0}}@else{{$cseo_count->countDraft}}@endif)</a></li>
                                  <li @if (app('request')->input('status_id')=='11') class="active" @endif><a href="{{ url( '/system/pages?status_id=11' ) }}">Trash (@if($cseo_count==null){{0}}@else{{$cseo_count->countTrash}}@endif)</a></li> 
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
                                          <button id="btn-bulkActionPages" type="button" class="btn btn-m btn-success btn-bulkActionPages">Apply</button>
                                      </div>
                                  </div>
                              </div>
                          </form>
                      </div>
                      <div class="col-md-3 pull-right">
                          <p class="badge badge-info"><span>{{ @$page_count }}</span> Item(s)</p>
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
                                  <th>Title</th>
                                  <th>Merchant</th>
                                  <th>Language</th>
                                  <th>Author</th>
                                  <th>Date</th>
                                  <th>Action</th>
                              </tr>
                          </thead>
                          <tbody>
                          @if(count($page)>0)
                              @foreach ($page as $pages)
                                  <tr class="gradeX table-item">
                                      <td class="text-center">
                                        <div class="checkbox checkbox-primary rows">
                                            <input type="checkbox" class="styled styled-primary check" id="pagesarr" name="pagesarr[]" value="{{$pages->page_id}}" >
                                            <label></label>
                                        </div>
                                      </td>
                                      <td class="hover">
                                          <strong>{{ucfirst($pages->page_title)}}  @if($pages->status_id == '12') <span class="text-center">--Draft</span> @endif</strong> 
                                      </td>
                                      <td>{{str_replace('http://','',$pages->merchant_name)}}</td>
                                      <td>{{$pages->name}}</td>
                                      <td>{{$pages->display_name}}</td>
                                      <td>{{$pages->created_at->format('F d, Y')}}</td>
                                      <td>
                                        @if($pages->status_id == '11')
                                          <span><a href="#" class="modalRestore" data-hover="tooltip" data-placement="top"  data-toggle="modal"  data-target="#ViewStatus-{{$pages->page_id}}" title="Restore"><button class="btn btn-success  dim" type="button"><i class="fa fa-refresh"></i></button><input type="hidden" id="Restoreid" name="Restoreid" value="{{$pages->page_id}}"></a></span>
                                          <span><a href="#" class="modalDelete text-danger" data-hover="tooltip" data-placement="top"  data-toggle="modal"  data-target="#ViewStatus-{{$pages->page_id}}" title="Delete"><button class="btn btn-danger  dim " type="button"><i class="fa fa-trash"></i></button><input type="hidden" id="Delid" name="Delid" value="{{$pages->page_id}}"></a></span>
                                        @else
                                          <span><a href="{{'/system/pages/'.$pages->page_id.'/edit'}}" class="text-info" title="Edit"><button class="btn btn-info  dim" type="button"><i class="fa fa-paste"></i> </button></a></span>
                                          <span><a href="#" class="modalTrash text-danger" data-hover="tooltip" data-placement="top"  data-toggle="modal"  data-target="#ViewStatus-{{$pages->page_id}}" title="Move To Trash"><button class="btn btn-danger  dim " type="button"><i class="fa fa-trash"></i></button><input type="hidden" id="Trashid" name="Trashid" value="{{$pages->page_id}}"></a></span>
                                        @endif
                                      </td>
                                  </tr>
                              @endforeach
                              @else
                              <tr class='gradeX'>
                                  <td colspan='6' align="center"><strong>No Record Found</strong></td>
                              </tr>
                          @endif       
                          </tbody>
                      </table>
                  </div> <!---.table-responsive-->
                  <div id="paginate" name="paginate">
                      {{ $page->links() }}
                  </div>  
              </div> <!---#page-Items-->
  </div>
</div>
</div>
@if(count($page)>0)
  @foreach ($page as $pages)
    <div class="modal fade" id="ViewStatus-{{$pages->page_id}}" tabindex="-1" role="dialog"  aria-hidden="true">
      <div class="modal-dialog modal-m">
        <div class="modal-content">
          <div class="modal-header bg-primary">
            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
            <h4 class="modal-title" id="modal-title">Delete Status</h4>
          </div>
          <div class="modal-body">
            <input type="hidden" id="page_id" name="page_id[]" class="pageid">
            <input type="hidden" id="status_now_{{$pages->page_id}}" name="status_now" value="{{$pages->status_id}}">
            <input type="hidden" id="curr_status_{{$pages->page_id}}" name="status_current" value="{{$pages->curr_status_id}}">
            <div class="container-fluid">
              <div class="col-lg-12 for-delete" style="display: none;">
                <form role="form" class="form-horizontal" >
                {{csrf_field()}}
                  <div class="form-group"><label>Do You want to Delete This Pages?</label></div>
                </form>   
              </div> 
              <div class="col-lg-12 for-restore" style="display: none;">
              <form role="form" class="form-horizontal" method="post">
              {{csrf_field()}}
              <div class="form-group"><label>Do You want to Restore This Pages?</label></div>
              </form>   
              </div> 
              <div class="col-lg-12 for-movetrash" style="display: none;">
                <form role="form" class="form-horizontal" method="post">
                {{csrf_field()}}
                  <div class="form-group"><label>Do You want to Trash This Pages?</label></div>
                </form>   
              </div>
            </div>
          </div>    
          <div class="modal-footer form-model-footer">
            <button type="button" id="cancel" class="btn btn-white" data-dismiss="modal">Cancel</button>
            <button type="button" id="deletePages" class="btn btn-danger deletePages" data-dismiss="modal" data-id="{{$pages->page_id}}">Delete</button>
            <button type="button" id="btn-moveActionPages" class="btn btn-primary restorePages btn-moveActionPages" data-dismiss="modal" data-id="{{$pages->page_id}}" style="display: none;">Restore</button>
            <button type="button" id="btn-moveActionPages" class="btn btn-danger trashPages btn-moveActionPages" data-dismiss="modal" data-id="{{$pages->page_id}}" style="display: none;">Move to Trash</button>
          </div>
        </div>
      </div>
    </div>
  @endforeach 
@endif
@endsection