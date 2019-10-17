@extends('layouts.master')
@section('title', $site_identity->site_title.' | '.strtoupper(str_replace('http://','', $merchant->merchant_name)).' - Reward')

@section('breadcrumb')
            <h2><i class="fa fa-trophy"></i> Reward</h2>
            <ol class="breadcrumb">
                   <li>
                      <a href="@if(Auth::user()->account_id !='4' ) /system/admin @else/system/support  @endif ">Dashboard</a>
                   </li>
                   <li>
                        <a href="{{ url('/system/reward') }}"> Reward</a>
                   </li>
                   <li class="active">
                       <strong>{{ strtoupper(str_replace('http://','', $merchant->merchant_name)) }} - Reward</strong>
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
                <h5>Add New Reward</h5>
            </div>
            <div class="ibox-content clearfix">
              <p><span><strong>Note:</strong></span> <i>Please Fill the Form Have This in Field</i> <strong class="text-danger"> (*)</strong> </span></p>
              <div class="hr-line-dashed"></div>
              <form id="formReward" role="form">
                {{csrf_field()}}
                <div class="form-group {{ $errors->has('place_reward') ? 'has-error' : '' }}"><label>Place Reward<strong class="text-danger"> *</strong></label> <input type="text" id='place_reward' name='place_reward' placeholder="Place Reward" class="form-control">
                @if($errors->has('place_reward'))
                    <span class="help-block">
                        <strong>{{ $errors->first('place_reward') }}</strong>
                    </span>
                @endif
                </div>
                <div class="form-group {{ $errors->has('amount') ? 'has-error' : '' }}"><label>Reward<strong class="text-danger"> *</strong></label> <input type="text" id='amount' name='amount' placeholder="Reward" class="form-control">
                @if($errors->has('amount'))
                    <span class="help-block">
                        <strong>{{ $errors->first('amount') }}</strong>
                    </span>
                @endif
                </div>
                <div class="form-group"><button class="btn btn-block btn-primary pull-left m-t-n-xs" type="button" id="AddnewReward"><strong>Save</strong></button>  </div>
              </form>
            </div>
          </div>
        </div> <!---.col-lg-4-->
        <div class="col-lg-8 animated fadeInRight">
          <div class="col-lg-12">
            <div class="ibox float-e-margins">
              <div class="ibox-title">
                <h5>{{ strtoupper(str_replace('http://','', $merchant->merchant_name)) }} - Reward</h5>

                <div class="pull-right">
                <input type="hidden" id="merchants_id" class="merchants_id" value="{{$reward[0]->merchants_id}}">
                <select class="form-control m-b" id="langname" name="langname" onchange="countrylang(this);" >
                    <option value="">--- Select Language ---</option>
                    @foreach ($lang as $langs)  
                        <option value="{{$langs->id }}" class="text-center" @if(old('merchantname', $langs->id) == @$reward[0]->lang_id) selected="selected" @endif> {{ $langs->name}} </option>
                    @endforeach
                </select> 
                </div>
              </div>
              <div class="ibox-content">
                <div class="row">
                    <div class="col-md-6">
                        
                    </div> <!---.col-lg-12-->

                    <div class="col-md-4 pull-right">
                  
                    </div>
                </div> <!---.row-->
                <div class="table-responsive" id="data_reward">
                  <table class="table table-striped table-bordered table-hover dataTables-example fixed" >
                    <thead>
                      <tr>
                       
                        <th>Place</th>
                        <th>Reward</th>
                        <th>Date</th>
                        <th>Action</th>
                      </tr>
                    </thead>

                      <tbody>
                      @if(!empty($reward))
                        @foreach ($reward as $rewards)
                          <tr class="gradeX table-item">
                            
                            <td class="hover">
                              <strong>{{$rewards->placereward}}</strong>
                            </td>
                            <td>{{$rewards->amount}}</td>
                            <td class="column-date">{{$rewards->created_at->format('Y/m/d')}}</td>
                            <td>
                               <span><a href="#" class="modalEdit" data-hover="tooltip" data-placement="top"  data-toggle="modal"  data-target="#ViewStatus-{{$rewards->id}}" title="Edit"><button class="btn btn-info  dim" type="button"><i class="fa fa-paste"></i></button><input type="hidden" id="Editid" name="Editid" value="{{$rewards->id}}"></a></small></span>
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
                   {{--  {{ $reward->links() }} --}}
                </div>
              </div>
            </div>
          </div>
        </div> <!---.col-lg-8-->
      </div> <!---.wrapper-->

  
  <div class="popedit">

      @if(!empty($reward))      
       @foreach ($reward as $rewards)
                 <div class="modal modal-box fade" id="ViewStatus-{{$rewards->id}}" tabindex="-1" role="dialog"  aria-hidden="true">
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
                                       <div class="form-group"><label>Place Reward</label> <input type="text" id='edplace_reward_{{$rewards->id}}' name='edplace_reward' placeholder="Place Reward" class="form-control" value="{{$rewards->placereward}}"></div>

                                         <div class="form-group"><label>Reward</label> <input type="text" id='edamount_{{$rewards->id}}' name='edamount' placeholder="Reward" class="form-control" value="{{$rewards->amount}}"></div>
                                                   
                                   </form>    



                                   </div> 
                                  <div class="col-lg-12 for-delete" style="display: none;">
                                              <form role="form" class="form-horizontal" >
                                              {{csrf_field()}}
                                                  <div class="form-group"><label>Do You want to Delete This Rewards?</label></div>
                                              </form>   
                                     </div> 
                                     <div class="col-lg-12 for-restore" style="display: none;">
                                              <form role="form" class="form-horizontal" method="post">
                                              {{csrf_field()}}
                                                  <div class="form-group"><label>Do You want to Restore This Rewards?</label></div>
                                              </form>   
                                     </div> 
                                     <div class="col-lg-12 for-movetrash" style="display: none;">
                                              <form role="form" class="form-horizontal" method="post">
                                              {{csrf_field()}}
                                                  <div class="form-group"><label>Do You want to Trash This Rewards?</label></div>
                                              </form>   
                                     </div> 
                               </div>
                           </div>    
                           <div class="modal-footer form-model-footer">
                             <button type="button" id="cancel" class="btn btn-white" data-dismiss="modal">Cancel</button>
                             <button type="button" id="saveRewardChanges" class="btn btn-primary saveRewardChanges" data-dismiss="modal" data-id="{{$rewards->id}}">Save Changes</button>
                             <button type="button" id="deleteBrand" class="btn btn-danger deleteBrand" data-dismiss="modal" style="display: none;">Delete</button>
                             <button type="button" id="btn-moveActionBrand" class="btn btn-primary restoreBrand btn-moveActionBrand" data-dismiss="modal" style="display: none;">Restore</button>
                             <button type="button" id="btn-moveActionBrand" class="btn btn-danger trashBrand btn-moveActionBrand" data-dismiss="modal" style="display: none;">Move to Trash</button>
                           </div>
                           </div>
                       </div>
               </div>
       @endforeach 
      @endif
    
    
  </div>

@endsection