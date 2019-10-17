@extends('layouts.master')
@section('title', $site_identity->site_title.' | Merchant')

@section('breadcrumb')
            <h2><i class="fa fa-list"></i> Merchant</h2>
            <ol class="breadcrumb">
                   <li>
                        <a href="@if(Auth::user()->account_id =='1')/system/admin @else/system/user @endif">Dashboard</a>
                   </li>
                   <li class="active">
                       <strong>Merchant</strong>
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
                <h5>Add New Merchant</h5>
            </div>
            <div class="ibox-content clearfix">
              <p><span><strong>Note:</strong></span> <i>Please Fill the Required Fields</i> <strong class="text-danger"> (*)</strong> </span></p>
              <div class="hr-line-dashed"></div>
              <form id="formMerchant" role="form">
                {{csrf_field()}}
                <div class="form-group {{ $errors->has('merchant_name') ? 'has-error' : '' }}"><label>Site URL<strong class="text-danger"> *</strong></label>
                  <input type="text" id='merchant_name' name='merchant_name' placeholder="Please add http://" class="form-control">
                  @if($errors->has('merchant_name'))
                      <span class="help-block">
                          <strong>{{ $errors->first('merchant_name') }}</strong>
                      </span>
                  @endif
                </div>
                <div class="form-group {{ $errors->has('merchant_title') ? 'has-error' : '' }}"><label>Site Title<strong class="text-danger"> *</strong></label>
                  <input type="text" id='merchant_title' name='merchant_title' placeholder="Site Title" class="form-control">
                  @if($errors->has('merchant_name'))
                      <span class="help-block">
                          <strong>{{ $errors->first('merchant_title') }}</strong>
                      </span>
                  @endif
                </div>
{{--                 <div class="form-group {{ $errors->has('team') ? 'has-error' : '' }}"><label>Team<strong class="text-danger"> *</strong></label> 
                  <select class="form-control m-b" id="team" name="team"  >
                      <option > - Select Team - </option>
                      @foreach ($team as $teams)  
                          <option value="{{$teams->id }}" class="text-center"> {{$teams->name }} </option>
                      @endforeach
                  </select>   
                  @if($errors->has('team'))
                      <span class="help-block">
                          <strong>{{ $errors->first('team') }}</strong>
                      </span>
                  @endif
                </div> --}}
                <div class="form-group"><button class="btn btn-block btn-primary pull-left m-t-n-xs" type="button" id="AddnewBrand"><strong>Save</strong></button>  </div>
              </form>
            </div>
          </div>
        </div> <!---.col-lg-4-->
        <div class="col-lg-8 animated fadeInRight">
          <div class="col-lg-12">
            <div class="ibox float-e-margins">
              <div class="ibox-title">
                <h5>Merchant</h5>
              </div>
              <div class="ibox-content">
                <div class="row">
                  

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

                    </div>

                    <div class="col-md-3 pull-right">
                        <p class="badge badge-info"><span id="brandCount">{{ $branding_count }}</span> Item(s)</p>
                          @if(!empty(app('request')->input('search')))  
                             Search results for <span class="">"{{app('request')->input('search')}}"</span>
                         @endif 
                    </div> 
                </div> <!---.row-->
                <div class="table-responsive" id="data_slider_category">
                  <table class="table table-striped table-bordered table-hover dataTables-example fixed" >
                    <thead>
                      <tr>
                       
                        <th>Merchant Name</th>
                        <!--<th>Team</th>-->
                        <th>Date</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                      <tbody>
                      @if(count($branding)>0)
                        @foreach ($branding as $merchant)
                          <tr class="gradeX table-item">
                            
                            <td class="hover">
                              <strong>{{str_replace('http://','',$merchant->merchant_name)}}</strong>
                            </td>
                            <!--<td>{{$merchant->team_name}}</td>-->
                            <td class="column-date">{{$merchant->created_at->format('Y/m/d')}}</td>
                            <td>
                                 @if($merchant->status_id == '11') 
                                   <span><small><a href="#" class="modalRestore" data-hover="tooltip" data-placement="top"  data-toggle="modal"  data-target="#ViewStatus-{{$merchant->id}}" ><button class="btn btn-success  dim" type="button"><i class="fa fa-refresh"></i></button><input type="hidden" id="Restoreid" name="Restoreid" value="{{$merchant->id}}"></a></small></span>             
                                   <!--<span><a href="#" class="modalDelete text-danger" data-hover="tooltip" data-placement="top"  data-toggle="modal"  data-target="#ViewStatus-{{$merchant->id}}" ><button class="btn btn-danger  dim" type="button"><i class="fa fa-trash"></i></button><input type="hidden" id="Delid" name="Delid" value="{{$merchant->id}}"></a></small></span>-->
                                 
                                 @elseif($merchant->status_id == '9')    
                                   <span><a href="#" class="modalEdit" data-hover="tooltip" data-placement="top"  data-toggle="modal"  data-target="#ViewStatus-{{$merchant->id}}" ><button class="btn btn-info  dim" type="button"><i class="fa fa-paste"></i> </button><input type="hidden" id="Editid" name="Editid" value="{{$merchant->id}}"></a></small></span>          
                                   <!--<span><a href="#" class="modalTrash text-danger" data-hover="tooltip" data-placement="top"  data-toggle="modal"  data-target="#ViewStatus-{{$merchant->id}}" ><button class="btn btn-danger  dim" type="button"><i class="fa fa-trash"></i></button><input type="hidden" id="Trashid" name="Trashid" value="{{$merchant->id}}"></a></small></span>-->
                                   <!--<span><small></small></span>-->
                                 
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
                </div><!---.table-responsive-->
                <div id="paginate" name="paginate">
                    {{ $branding->links() }}
                </div>
              </div>
            </div>
          </div>
        </div> <!---.col-lg-8-->
      </div> <!---.wrapper-->
@if(count($branding)>0)      
 @foreach ($branding as $merchant)
           <div class="modal modal-box fade" id="ViewStatus-{{$merchant->id}}" tabindex="-1" role="dialog"  aria-hidden="true">
             <div class="modal-dialog modal-m">
                 <div class="modal-content">
                     <div class="modal-header bg-primary">
                         <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                         <h3 class="modal-title" id="modal-title"><i class="fa fa-edit"></i> Edit</h3>
                     </div>
                     <div class="modal-body">
                         <input type="hidden" id="brandid" name="brandid[]" class="brandid">
                         <div class="clearfix">
                             <div class="col-lg-12 for-edit">
                             <form id="formcategory" role="form" class="form-horizontal">
                             {{csrf_field()}}
                                 <div class="form-group"><label>Name</label> <input type="text" id='edbrand_name_{{$merchant->id}}' name='edbrand_name' placeholder="Name" class="form-control" value="{{$merchant->merchant_name}}"></div>
                                  
                                <div class="form-group"><label>Team</label> 
                                  <select class="form-control m-b" id="team_{{$merchant->id}}" name="team"  >
                                      <option > - Select Team - </option>
                                      @foreach ($team as $teams)  
                                          <option value="{{$teams->id}}" class="text-center" @if(old('team', $teams->id) == $merchant->team_merchant_id) selected="selected" @endif> {{$teams->name }} </option>
                                      @endforeach
                                  </select>   
                                </div>

                                 <div class="form-group"><label>Description</label> <textarea id='eddescription_{{$merchant->id}}' name='eddescription' rows="10" placeholder="Description" class="form-control">{{$merchant->description}}</textarea> </div>                           
                             </form>    
                             </div> 
                            <div class="col-lg-12 for-delete" style="display: none;">
                                        <form role="form" class="form-horizontal" >
                                        {{csrf_field()}}
                                            <div class="form-group"><label>Do You want to Delete This Merchant?</label></div>
                                        </form>   
                               </div> 
                               <div class="col-lg-12 for-restore" style="display: none;">
                                        <form role="form" class="form-horizontal" method="post">
                                        {{csrf_field()}}
                                            <div class="form-group"><label>Do You want to Restore This Merchant?</label></div>
                                        </form>   
                               </div> 
                               <div class="col-lg-12 for-movetrash" style="display: none;">
                                        <form role="form" class="form-horizontal" method="post">
                                        {{csrf_field()}}
                                            <div class="form-group"><label>Do You want to Trash This Merchant?</label></div>
                                        </form>   
                               </div> 
                         </div>
                     </div>    
                     <div class="modal-footer form-model-footer">
                       <button type="button" id="cancel" class="btn btn-white" data-dismiss="modal">Cancel</button>
                       <button type="button" id="saveBrandChanges" class="btn btn-primary saveBrandChanges" data-dismiss="modal">Save Changes</button>
                       <button type="button" id="deleteBrand" class="btn btn-danger deleteBrand" data-dismiss="modal" style="display: none;">Delete</button>
                       <button type="button" id="btn-moveActionBrand" class="btn btn-primary restoreBrand btn-moveActionBrand" data-dismiss="modal" style="display: none;">Restore</button>
                       <button type="button" id="btn-moveActionBrand" class="btn btn-danger trashBrand btn-moveActionBrand" data-dismiss="modal" style="display: none;">Move to Trash</button>
                     </div>
                     </div>
                 </div>
         </div>
 @endforeach 
@endif
@endsection