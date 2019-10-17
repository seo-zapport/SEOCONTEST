@extends('layouts.master')
@section('title', $site_identity->site_title.' | Bank')

@section('breadcrumb')
            <h2><i class="fa fa-list"></i> Bank</h2>
            <ol class="breadcrumb">
                   <li>
                        <a href="@if(Auth::user()->account_id =='1')/system/admin @else/system/user @endif">Dashboard</a>
                   </li>
                   <li class="active">
                       <strong>Bank</strong>
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
                <h5>Add New Bank</h5>
            </div>
            <div class="ibox-content clearfix">
              <p><span><strong>Note:</strong></span> <i>Please Fill the Required Fields</i> <strong class="text-danger"> (*)</strong> </span></p>
              <div class="hr-line-dashed"></div>
              <form id="formBank" role="form">
                {{csrf_field()}}
                <div class="form-group {{ $errors->has('bname') ? 'has-error' : '' }}"><label>Bank Name<strong class="text-danger"> *</strong></label>
                  <input type="text" id='bname' name='bname' placeholder="Bank Name" class="form-control">
                  @if($errors->has('bname'))
                      <span class="help-block">
                          <strong>{{ $errors->first('bname') }}</strong>
                      </span>
                  @endif
                </div>
                <div class="form-group {{ $errors->has('bacronym') ? 'has-error' : '' }}"><label>Bank Acronym<strong class="text-danger"> *</strong></label>
                  <input type="text" id='bacronym' name='bacronym' placeholder="Bank Acronym" class="form-control">
                  @if($errors->has('bacronym'))
                      <span class="help-block">
                          <strong>{{ $errors->first('bacronym') }}</strong>
                      </span>
                  @endif
                </div>
                <div class="form-group" {{ $errors->has('lang') ? 'has-error' : '' }}"><label>Currency</label> 
                  <select class="form-control m-b" id="lang" name="lang"  >
                      <option > - Select Currency - </option>
                      @foreach ($lang as $langs)  
                          <option value="{{$langs->id}}" class="text-center" > {{$langs->name }} </option>
                      @endforeach
                  </select>   
                  @if($errors->has('lang'))
                      <span class="help-block">
                          <strong>{{ $errors->first('lang') }}</strong>
                      </span>
                  @endif
                </div>

                <div class="form-group"><button class="btn btn-block btn-primary pull-left m-t-n-xs" type="button" id="AddnewBrand"><strong>Save</strong></button>  </div>
              </form>
            </div>
          </div>
        </div> <!---.col-lg-4-->
        <div class="col-lg-8 animated fadeInRight">
          <div class="col-lg-12">
            <div class="ibox float-e-margins">
              <div class="ibox-title">
                <h5>Bank</h5>
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
                              
                          </div>
                      </form>
                    </div>
                </div> <!---.row-->
                <div class="row">
                    <div class="col-md-6">
                    </div>

                    <div class="col-md-3 pull-right">
                        <p class="badge badge-info"><span id="bankCount">{{ $bank_count }}</span> Item(s)</p>
                          @if(!empty(app('request')->input('search')))  
                             Search results for <span class="">"{{app('request')->input('search')}}"</span>
                         @endif 
                    </div> 
                </div> <!---.row-->
                <div class="table-responsive" id="data_slider_category">
                  <table class="table table-striped table-bordered table-hover dataTables-example fixed" >
                    <thead>
                      <tr>
                        <th>Bank Name</th>
                        <th>Bank Acronym</th>
                        <th>Currency</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                      <tbody>
                      @if(count($bank)>0)
                        @foreach ($bank as $banks)
                          <tr class="gradeX table-item">
                            
                            <td class="hover">
                              <strong>{{str_replace('http://','',$banks->name)}}</strong>
                            </td>
                            <td class="column-date">{{$banks->bank_acronym}}</td>
                            <td>{{$banks->lang_name}}</td>
                            <td>
                                
                                   <span><a href="#" class="modalEdit" data-hover="tooltip" data-placement="top"  data-toggle="modal"  data-target="#ViewStatus-{{$banks->id}}" ><button class="btn btn-info  dim" type="button"><i class="fa fa-paste"></i> </button><input type="hidden" id="Editid" name="Editid" value="{{$banks->id}}"></a></small></span>          
                                   <!--<span><a href="#" class="modalTrash text-danger" data-hover="tooltip" data-placement="top"  data-toggle="modal"  data-target="#ViewStatus-{{$banks->id}}" ><button class="btn btn-danger  dim" type="button"><i class="fa fa-trash"></i></button><input type="hidden" id="Trashid" name="Trashid" value="{{$banks->id}}"></a></small></span>-->
                                   <!--<span><small></small></span>-->
                                                   
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
                    {{ $bank->links() }}
                </div>
              </div>
            </div>
          </div>
        </div> <!---.col-lg-8-->
      </div> <!---.wrapper-->
@if(count($bank)>0)      
 @foreach ($bank as $banks)
           <div class="modal modal-box fade" id="ViewStatus-{{$banks->id}}" tabindex="-1" role="dialog"  aria-hidden="true">
             <div class="modal-dialog modal-m">
                 <div class="modal-content">
                     <div class="modal-header bg-primary">
                         <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                         <h3 class="modal-title" id="modal-title"><i class="fa fa-edit"></i> Edit</h3>
                     </div>
                     <div class="modal-body">
                         <input type="hidden" id="bankid" name="bankid[]" class="bankid">
                         <div class="clearfix">
                             <div class="col-lg-12 for-edit">
                             <form id="formcategory" role="form" class="form-horizontal">
                             {{csrf_field()}}
                                <div class="form-group"><label>Name</label> <input type="text" id='edb_name_{{$banks->id}}' name='edbrand_name' placeholder="Name" class="form-control" value="{{$banks->name}}"></div>
                                
                                <div class="form-group"><label>Bank Acronym</label> <input type="text" id='edbank_acronym_{{$banks->id}}' name='edbank_acronym' placeholder="Name" class="form-control" value="{{$banks->bank_acronym}}"></div>
                                  
                                <div class="form-group"><label>Currency</label> 
                                  <select class="form-control m-b" id="team_{{$banks->id}}" name="lang"  >
                                      <option > - Select Currency - </option>
                                      @foreach ($lang as $langs)  
                                          <option value="{{$langs->id}}" class="text-center" @if(old('lang', $langs->id) == $banks->lang_id) selected="selected" @endif> {{$langs->name }} </option>
                                      @endforeach
                                  </select>   
                                </div>
                                               
                             </form>    
                             </div> 
                            <div class="col-lg-12 for-delete" style="display: none;">
                                        <form role="form" class="form-horizontal" >
                                        {{csrf_field()}}
                                            <div class="form-group"><label>Do You want to Delete This Bank?</label></div>
                                        </form>   
                               </div> 
                               <div class="col-lg-12 for-restore" style="display: none;">
                                        <form role="form" class="form-horizontal" method="post">
                                        {{csrf_field()}}
                                            <div class="form-group"><label>Do You want to Restore This Bank?</label></div>
                                        </form>   
                               </div> 
                               <div class="col-lg-12 for-movetrash" style="display: none;">
                                        <form role="form" class="form-horizontal" method="post">
                                        {{csrf_field()}}
                                            <div class="form-group"><label>Do You want to Trash This Bank?</label></div>
                                        </form>   
                               </div> 
                         </div>
                     </div>    
                     <div class="modal-footer form-model-footer">
                       <button type="button" id="cancel" class="btn btn-white" data-dismiss="modal">Cancel</button>
                       <button type="button" id="saveBankChanges" class="btn btn-primary saveBankChanges" data-dismiss="modal">Save Changes</button>
                       <button type="button" id="deleteBank" class="btn btn-danger deleteBank" data-dismiss="modal" style="display: none;">Delete</button>
                     </div>
                     </div>
                 </div>
         </div>
 @endforeach 
@endif
@endsection



