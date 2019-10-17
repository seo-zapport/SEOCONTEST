@extends('layouts.master')
@section('title', $site_identity->site_title.' | Category')

@section('breadcrumb')
            <h2><i class="fa fa-list"></i> Category</h2>
            <ol class="breadcrumb">
                   <li>
                       <a href="@if(Auth::user()->account_id !='4' ) /system/admin @else/system/support  @endif ">Dashboard</a>
                   </li>
                   <li class="active">
                       <strong>Category</strong>
                   </li>
            </ol>
@endsection

@section('admin-content')

      <div class="wrapper wrapper-content clearfix">
        <div id="alert_box" class="col-lg-12 ">  @include('layouts.messages.messages') 
        @if(count($errors))
            <div class="alert alert-danger">
                <strong>Whoops!</strong> There were some problems with your input.
                <br/>
                <ul>
                    @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        </div>
        <div class="col-lg-4">
          <div class="ibox float-e-margins clearfix">
            <div class="ibox-title">
                <h5>Add New Category</h5>
            </div>
            <div class="ibox-content clearfix">
              <p><span><strong>Note:</strong></span> <i>Please Fill the Form Have This in Field</i> <strong class="text-danger"> (*)</strong> </span></p>
              <div class="hr-line-dashed"></div>
              <form id="formcategory" role="form">
                {{csrf_field()}}
                <div class="form-group {{ $errors->has('category_name') ? 'has-error' : '' }}"><label>Name<strong class="text-danger"> *</strong></label> <input type="text" id='category_name' name='category_name' placeholder="Name" class="form-control">
                @if($errors->has('category_name'))
                    <span class="help-block">
                        <strong>{{ $errors->first('category_name') }}</strong>
                    </span>
                @endif
                </div>
                <div class="form-group"><label>Description</label> <textarea id='description' name='description' rows="10" placeholder="Description" class="form-control"></textarea> </div>
                <div class="form-group"><button class="btn btn-block btn-primary pull-left m-t-n-xs" type="button" id="AddnewCat"><strong>Save</strong></button>  </div>
              </form>
            </div>
          </div>
        </div> <!---.col-lg-4-->
        <div class="col-lg-8 animated fadeInRight">
          <div class="col-lg-12">
            <div class="ibox float-e-margins">
              <div class="ibox-title">
                <h5>Category</h5>
              </div>
              <div class="ibox-content">
                <div class="row">
                    <div class="col-md-6">
                        <div class="status">
                            <ul class="nav">
                                <li @if (app('request')->input('status_id')=='') class="active" @endif><a href="{{ url( '/system/banner/category' ) }}">All (@if(count($cseo_count)>0){{$cseo_count->countAll}}@else{{0}}@endif)</a></li>
                                  <li @if (app('request')->input('status_id')=='9') class="active" @endif><a href="{{ url( '/system/banner/category?status_id=9' ) }}">Published (@if(count($cseo_count)>0){{$cseo_count->countPublished}}@else{{0}}@endif)</a></li>
                                  <li @if (app('request')->input('status_id')=='11') class="active" @endif><a href="{{ url( '/system/banner/category?status_id=11' ) }}">Trash (@if(count($cseo_count)>0){{$cseo_count->countTrash}}@else{{0}}@endif)</a></li>
                            </ul>
                        </div>
                    </div> <!---.col-lg-12-->

                    <div class="col-md-4 pull-right">
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
                    <div class="col-md-6">
                      <form role="form" class="form-horizontal col-md-5" method="post">
                          {{csrf_field()}}         
                          <div class="form-group">
                              <div class="input-group">
                                  <select class="form-control m-b" id="bulkAction" name="bulkAction" required autofocus>
                                      <option value=""> -Bulk Action- </option>
                                  </select> 
                                  <div class="input-group-btn">
                                      <button id="btn-bulkActioncat" type="button" class="btn btn-m btn-success btn-bulkActioncat">Apply</button>
                                  </div>
                              </div>
                          </div>
                      </form>
                    </div>

                    <div class="col-md-3 pull-right">
                        <p class="badge badge-info"><span id="brandCount">{{ $category_count }}</span> Item(s)</p>
                          @if(!empty(app('request')->input('search')))  
                             Search results for <span class="">"{{app('request')->input('search')}}"</span>
                         @endif 
                    </div> 
                </div> <!---.row-->
                <div class="table-responsive" id="data_slider_category">
                  <table class="table table-striped table-bordered table-hover dataTables-example fixed" >
                    <thead>
                      <tr>
                        <th class="text-center"><input type="checkbox" class="i-checks selectAll" id="selectAll"></th>
                        <th>Name</th>
                        <th>Description</th>
                        <th>Date</th>
                        <th>Count</th>
                      </tr>
                    </thead>
                      <tbody>
                      @if(count($category)>0)
                        @foreach ($category as $categories)
                          <tr class="gradeX table-item">
                            <td class="text-center" style="width: 50px;"><input type="checkbox" class="check i-checks" name="catarr[]" value="{{$categories->id}}"></td>
                            <td class="hover">
                              <strong>{{$categories->category_name}}</strong>
                              <div class="page-tooltip">
                                @if($categories->status_id == '11') 
                                  <span><small><a href="#" class="modalRestore" data-hover="tooltip" data-placement="top"  data-toggle="modal"  data-target="#ViewStatus-{{$categories->id}}" ><i class="fa fa-refresh"></i> Restore <input type="hidden" id="Restoreid" name="Restoreid" value="{{$categories->id}}"></a></small></span>|               
                                  <span><a href="#" class="modalDelete text-danger" data-hover="tooltip" data-placement="top"  data-toggle="modal"  data-target="#ViewStatus-{{$categories->id}}" ><i class="fa fa-trash"></i> Delete <input type="hidden" id="Delid" name="Delid" value="{{$categories->id}}"></a></small></span>
                                  @elseif($categories->status_id == '9')    
                                  <span><a href="#" class="modalEdit" data-hover="tooltip" data-placement="top"  data-toggle="modal"  data-target="#ViewStatus-{{$categories->id}}" ><i class="fa fa-paste"></i> Edit <input type="hidden" id="Editid" name="Editid" value="{{$categories->id}}"></a></small></span>|           
                                  <span><a href="#" class="modalTrash text-danger" data-hover="tooltip" data-placement="top"  data-toggle="modal"  data-target="#ViewStatus-{{$categories->id}}" ><i class="fa fa-trash"></i> Move To Trash <input type="hidden" id="Trashid" name="Trashid" value="{{$categories->id}}"></a></small></span>|
                                  <a href="{{'/system/banner/category/'.$categories->id}}"><i class="fa fa-eye"></i> View</a>
                                  <span><small></small></span>
                                @endif
                              </div>
                            </td>
                            <td class="column-desc">{{$categories->description}}</td>
                            <td class="column-date">{{$categories->created_at->format('Y/m/d')}}</td>
                            <td class="text-center column-status"><a href="{{'/system/banner/category/'.$categories->id}}" class="btn btn-link"> {{$categories->counted}} </a></td>
                          </tr>
                        @endforeach
                      @else
                        <tr class='gradeX'>
                          <td colspan='6' align="center"><strong>No Record Found</strong></td>
                        </tr>
                      @endif                
                      </tbody>
                  </table>
                </div><!---.table-responsive-->
                <div id="paginate" name="paginate">
                    {{ $category->links() }}
                </div>
              </div>
            </div>
          </div>
        </div> <!---.col-lg-8-->
      </div> <!---.wrapper-->
@if(count($category)>0)      
 @foreach ($category as $categories)
           <div class="modal modal-box fade" id="ViewStatus-{{$categories->id}}" tabindex="-1" role="dialog"  aria-hidden="true">
             <div class="modal-dialog modal-m">
                 <div class="modal-content">
                     <div class="modal-header bg-primary">
                         <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                         <h3 class="modal-title" id="modal-title"><i class="fa fa-edit"></i> Edit</h3>
                     </div>
                     <div class="modal-body">
                         <input type="hidden" id="catid" name="catid[]" class="catid">
                         <div class="clearfix">
                             <div class="col-lg-12 for-edit">
                             <form id="formcategory" role="form" class="form-horizontal">
                             {{csrf_field()}}
                                 <div class="form-group"><label>Name</label> <input type="text" id='edcategory_name_{{$categories->id}}' name='edcategory_name' placeholder="Name" class="form-control" value="{{$categories->category_name}}"></div>
                                 <div class="form-group"><label>Description</label> <textarea id='eddescription_{{$categories->id}}' name='eddescription' rows="10" placeholder="Description" class="form-control">{{$categories->description}}</textarea> </div>                           
                             </form>    
                             </div> 
                            <div class="col-lg-12 for-delete" style="display: none;">
                                        <form role="form" class="form-horizontal" >
                                        {{csrf_field()}}
                                            <div class="form-group"><label>Do You want to Delete This Category?</label></div>
                                        </form>   
                               </div> 
                               <div class="col-lg-12 for-restore" style="display: none;">
                                        <form role="form" class="form-horizontal" method="post">
                                        {{csrf_field()}}
                                            <div class="form-group"><label>Do You want to Restore This Category?</label></div>
                                        </form>   
                               </div> 
                               <div class="col-lg-12 for-movetrash" style="display: none;">
                                        <form role="form" class="form-horizontal" method="post">
                                        {{csrf_field()}}
                                            <div class="form-group"><label>Do You want to Trash This Category?</label></div>
                                        </form>   
                               </div> 
                         </div>
                     </div>    
                     <div class="modal-footer form-model-footer">
                       <button type="button" id="cancel" class="btn btn-white" data-dismiss="modal">Cancel</button>
                       <button type="button" id="saveCatChanges" class="btn btn-primary saveCatChanges" data-dismiss="modal">Save Changes</button>
                       <button type="button" id="deleteCat" class="btn btn-danger deleteCat" data-dismiss="modal" style="display: none;">Delete</button>
                       <button type="button" id="btn-moveActioncat" class="btn btn-primary restoreCountry btn-moveActioncat" data-dismiss="modal" style="display: none;">Restore</button>
                       <button type="button" id="btn-moveActioncat" class="btn btn-danger trashCountry btn-moveActioncat" data-dismiss="modal" style="display: none;">Move to Trash</button>
                     </div>
                     </div>
                 </div>
         </div>
 @endforeach 
@endif
@endsection



