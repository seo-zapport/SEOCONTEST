@extends('layouts.master')
@section('title', $site_identity->site_title.' | Contestant')
@section('breadcrumb')
	<h2><i class="fa fa-file-o"></i> Contestant</h2>
  <ol class="breadcrumb">
                   <li>
                       <a href="@if(Auth::user()->account_id !='4' ) /system/admin @else/system/support  @endif ">Dashboard</a>
                   </li>
                   <li class="active">
                       <strong>Contestant</strong>
                   </li>
            </ol>
@endsection
@section('admin-content')

    <div class="wrapper wrapper-content clearfix">
        <div class="ibox">
            <div class="ibox-title">
                <h5>Participants List</h5>
                							<div class="pull-right">

								<div class="btn-group">

									<button type="button" class="btn btn-sm btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">

										<i class="fa fa-file-excel-o" aria-hidden="true"></i> Excel <span class="caret"></span>

									</button>

									<ul class="dropdown-menu">

										<li><a href="{{ url('/system/contest?export=pending') }}">Pending</a></li>

										<li><a href="{{ url('/system/contest?export=approved') }}">Approved</a></li>

										<li><a href="{{ url('/system/contest?export=disqualified') }}">Disqualified</a></li>

										<li><a href="{{ url('/system/contest?export=trash') }}">Trash</a></li>

										<li><div class="divider"></div></li>

										<li><a href="{{ url('/system/contest?export=All') }}">All</a></li>

									</ul>

								</div>


							</div>
            </div>
            <div class="tabs-container ibox-content">
                <div id="Participants-Items">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="status">
                                        <ul class="nav">
                                            <li @if (app('request')->input('status_id')=='') class="active" @endif><a href="{{ url( '/system/contest' ) }}">All (@if(count($cseo_contest_count)>0){{$cseo_contest_count->countAll}}@else{{0}}@endif)</a></li>
                                            <li @if (app('request')->input('status_id')=='6') class="active" @endif><a href="{{ url( '/system/contest?status_id=6' ) }}">Pending (@if(count($cseo_contest_count)>0){{$cseo_contest_count->countPending}}@else{{0}}@endif)</a></li>
                                            <li @if (app('request')->input('status_id')=='7') class="active" @endif><a href="{{ url( '/system/contest?status_id=7' ) }}">Approved (@if(count($cseo_contest_count)>0){{$cseo_contest_count->countApproved}}@else{{0}}@endif)</a></li>
                                            <li @if (app('request')->input('status_id')=='8') class="active" @endif><a href="{{ url( '/system/contest?status_id=8' ) }}">Disqualified (@if(count($cseo_contest_count)>0){{$cseo_contest_count->countDisqualified}}@else{{0}}@endif)</a></li> 
                                            <li @if (app('request')->input('status_id')=='11') class="active" @endif><a href="{{ url( '/system/contest?status_id=11' ) }}">Trash (@if(count($cseo_contest_count)>0){{$cseo_contest_count->countTrash}}@else{{0}}@endif)</a></li> 
                                             
                                        </ul>
                                    </div>
                                </div> <!---.col-lg-12-->
                                <div class="col-md-3 pull-right">
                                    <!-- Search box  -->        
                                    <form role="form" class="form-horizontal pull-right"  method="get"  >
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
                                    <form role="form" class="form-horizontal col-md-5" method="post"> 
                                        {{csrf_field()}}         
                                        <div class="form-group">
                                            <div class="input-group">
                                                <select class="form-control m-b" id="bulkActionParticipant" name="bulkActionParticipant" required autofocus>
                                                    <option value=""> -Bulk Action- </option>
                                                </select> 
                                                <div class="input-group-btn">
                                                    <button id="btn-bulkActionConstest" type="button" class="btn btn-m btn-success btn-bulkActionConstest">Apply</button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="col-md-3 pull-right">
                                    <p class="badge badge-info"><span>{{ $con_count }}</span> Item(s)</p>
                                      @if(!empty(app('request')->input('search')))  
                                         Search results for <strong>"{{app('request')->input('search')}}"</strong>
                                     @endif 
                                </div>
                            </div> <!---.row-->
                            <div class="table-responsive">
                                <table class="footable table table-stripped toggle-arrow-tiny default table-bordered" > 
                                    <thead>
                                        <tr>
                                            <th data-hide="all"></th>
                                            <th data-sort-ignore="true" class="text-center">
                                              <div class="checkbox checkbox-primary">
                                                  <input type="checkbox" class="styled styled-primary" id="selectAll" name="selectAll">
                                                  <label></label>
                                              </div>
                                            </th>
                                            <th>Merchant</th>
                                            <th>Language</th>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th data-breakpoints="xs sm">Url Website Contest</th>
                                            <th data-hide="all" style="display: none;" data-breakpoints="xs sm">Mobile no.</th>
                                            <!--<th data-hide="all" style="display: none;" >BBM Pin</th>-->
                                            <th data-hide="all" style="display: none;" >Bank Name</th>
                                            <th data-hide="all" style="display: none;" >Account No.</th>
                                            <th data-hide="all" style="display: none;" >Behalf of Account</th>
                                            <th data-breakpoints="xs sm">Data Registered</th>
                                            <th data-breakpoints="xs sm">Status</th>
                                            <th data-sort-ignore="true" data-breakpoints="xs sm">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    @if(count($register)>0)
                                        @foreach ($register as $registers)
                                            <tr data-expanded="true">
                                                <td data-hide="all"></td>
                                                
                                                @php 
                                                   if($registers->status_name == "Approved"){ 
                                                      $classstat = "success"; 
                                                      $bordercolor = " border-left: #1c84c6 9px solid;";    
                                                   }elseif($registers->status_name == "Disqualified"){ 
                                                      $classstat = "danger"; 
                                                      $bordercolor = " border-left: #ed5565 9px solid";
                                                    }else{ 
                                                      $classstat = "warning"; 
                                                      $bordercolor = " border-left: #f8ac59 9px solid;";    
                                                    }
                                                 @endphp
                                                
                                                
                                                <td style="width: 50px; {{$bordercolor}}" class="text-center">
                                                  <div class="checkbox checkbox-primary rows">
                                                      <input type="checkbox" class="styled styled-primary check" id="contestarr" name="contestarr[]" value="{{$registers->reg_id}}" >
                                                      <label></label>
                                                  </div>
                                                </td>
                                                <td>{{str_replace('http://','',$registers->merchant_name)}}</td>
                                                <td>{{$registers->name}}</td>
                                                <td>
                                                  {{ucfirst($registers->rname)}} <strong>@if($registers->created_at >= \Carbon\Carbon::now()->subHour(24))<span class="badge badge-primary">New</span>@endif</strong>
                                                </td>
                                                <td>{{$registers->email}}</td>
                                                <td><a href="{{addhttpurl($registers->url_web_contest)}}" target="_blank" title="{{$registers->url_web_contest}}">{{$registers->url_web_contest}}</a></td>
                                                <td style="display: none;">{{$registers->mobile_number}}</td>
                                                <!--<td style="display: none;">@if(empty($registers->pin_bbm)){{'xxxxxxxx'}} @else{{$registers->pin_bbm}}@endif</td>-->
                                                <td style="display: none;">{{$registers->bname}}</td>
                                                <td style="display: none;">{{$registers->account_no}}</td>
                                                <td style="display: none;">{{$registers->behalfofaccount}}</td>
                                                <td>{{$registers->created_at->format('Y/m/d')}}</td>
                                                <td>@if($registers->verify_status =="0" && $registers->status_name == "Pending")
                                                    <p><span class="label label-warning">{{$registers->status_name}}</span></p> 
                                                    @else  
                                                      
                                                    <p><span class="label label-{{$classstat}}">{{$registers->status_name}}</span></p> 
                                                   {{--  @if($registers->verify_status !="0")
                                                    <span class="badge badge-primary">Confirmed</span>
                                                    @else
                                                    <span class="badge badge-warning">Pending</span> 
                                                    @endif   --}}
                                                    @endif
                                                </td> 
                                                <td>
                                                    @if($registers->status_id == '11')
                                                      <span><a href="#" class="modalRestore" data-hover="tooltip" data-placement="top"  data-toggle="modal"  data-target="#ViewStatus-{{$registers->reg_id}}" title="Restore"><button class="btn btn-primary dim" type="button"><i class="fa fa-refresh"></i></button><input type="hidden" id="Restoreid" name="Restoreid" value="{{$registers->reg_id}}"></a></span>
                                                      <span><a href="#" class="modalDelete" data-hover="tooltip" data-placement="top"  data-toggle="modal"  data-target="#ViewStatus-{{$registers->reg_id}}" title="Delete" ><button class="btn btn-danger  dim " type="button"><i class="fa fa-trash"></button></i><input type="hidden" id="Delid" name="Delid" value="{{$registers->reg_id}}"></a></span>
                                                    @else
                                                      @if($registers->status_id == '6' || $registers->status_id == '8')
                                                        <span><a href="#" class="modalApproved" data-hover="tooltip" data-placement="top"  data-toggle="modal"  data-target="#ViewStatus-{{$registers->reg_id}}" title="Approved"><button class="btn btn-success  dim" type="button"><i class="fa fa-check"></i></button><input type="hidden" id="Approvedid" name="Approvedid" value="{{$registers->reg_id}}"></a></span>
                                                      @endif
                                                      @if($registers->status_id == '7' || $registers->status_id == '8')
                                                        <span><a href="#" class="modalPending" data-hover="tooltip" data-placement="top"  data-toggle="modal"  data-target="#ViewStatus-{{$registers->reg_id}}" title="Pending"><button class="btn btn-warning dim" type="button"><i class="fa fa-files-o"></i></button><input type="hidden" id="Pendingid" name="Pendingid" value="{{$registers->reg_id}}"></a></span>
                                                      @endif  
                                                      @if($registers->status_id == '6' || $registers->status_id == '7')
                                                        <span><a href="#" class="modalDisqualified" data-hover="tooltip" data-placement="top"  data-toggle="modal"  data-target="#ViewStatus-{{$registers->reg_id}}" title="Disqualified"><button class="btn btn-danger  dim " type="button"><i class="fa fa-remove"></i></button><input type="hidden" id="Disqualifiedid" name="Disqualifiedid" value="{{$registers->reg_id}}"></a></span>

                                                      @endif
                                                      <span><a href="#" class="modalTrash text-danger" data-hover="tooltip" data-placement="top"  data-toggle="modal"  data-target="#ViewStatus-{{$registers->reg_id}}" title="Move To Trash"><button class="btn btn-danger  dim " type="button"><i class="fa fa-trash"></i></button><input type="hidden" id="Trashid" name="Trashid" value="{{$registers->reg_id}}"></a></span>
                                                    @endif
                                                </td> 
                                            </tr>
                                            <tr class="footable-row-detail" style="display: none;">
                                              <td class="footable-row-detail-cell" colspan="4">
                                                <div class="footable-row-detail-inner">
                                                  <div class="footable-row-detail-row">
                                                    <div class="footable-row-detail-name">BBM Pin:</div>
                                                    <div class="footable-row-detail-value">{{$registers->pin_bbm}}</div>
                                                  </div>
                                                  <div class="footable-row-detail-row">
                                                    <div class="footable-row-detail-name">Bank Name:</div>
                                                    <div class="footable-row-detail-value">{{$registers->bank_id}}</div>
                                                  </div>
                                                  <div class="footable-row-detail-row">
                                                    <div class="footable-row-detail-name">Account No:</div>
                                                    <div class="footable-row-detail-value">{{$registers->account_no}}</div>
                                                  </div>
                                                  <div class="footable-row-detail-row">
                                                    <div class="footable-row-detail-name">Behalf of AccountZ:</div>
                                                    <div class="footable-row-detail-value">{{$registers->behalfofaccount}}</div>
                                                  </div>
                                                </div>
                                              </td>
                                            </tr>
                                        @endforeach
                                        @else
                                        <tr class='gradeX'>
                                            <td colspan='10' align="center"><strong>No Record Found</strong></td>
                                        </tr>
                                    @endif       
                                    </tbody>
                                    <tfoot class="hide-if-no-paging">
                                        <tr>
                                        <td colspan='10' align="center" class="footable-visible">
                                            <div class="pagination"></div>
                                        </td>
                                        </tr>
                                    </tfoot>
                                    
                                    
                                </table>
                            </div> <!---.table-responsive-->
                            <div id="paginate" name="paginate" class="pull-right">
                                {{ $register->links() }}
                            </div>  
                        </div> 
            </div>
        </div>
    </div>

    @foreach ($register as $registers)

        @php 
        if($registers->status_name == "Approved"){ $classstat = "success";}elseif($registers->status_name == "Disqualified"){ $classstat = "danger"; }else{ $classstat = "warning"; }
        @endphp

        <div class="modal fade" id="ViewStatus-{{$registers->reg_id}}" tabindex="-1" role="dialog"  aria-hidden="true">
          <div class="modal-dialog modal-m">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title" id="modal-title">Delete Status</h4>
              </div>
              <div class="modal-body">
                <input type="hidden" id="reg_id_{{$registers->reg_id}}" name="reg_id[]" class="regid" value="{{$registers->reg_id}}">
                <input type="hidden" id="status_now_{{$registers->reg_id}}" name="status_now" value="{{$registers->status_id}}">
                <input type="hidden" id="curr_status_{{$registers->reg_id}}" name="status_current" value="{{$registers->curr_status_id}}">
                <div class="container-fluid">
                  <div class="col-lg-12 for-view" style="display: none;">
                    <form role="form" class="form-horizontal" >
                    {{csrf_field()}}
                      
                        <div class="form-model-stats-box">Status: <span class="text-{{$classstat}}">{{ $registers->status_name }}</span></div>
                    
                        <div class="form-group">
                          <label class="control-label" for="Name">Name</label>
                          <input type="text" class="form-control" id="full_name" name="full_name" placeholder="Enter Name" value="{{ucfirst($registers->rname)}}">
                        </div>

                        <div class="form-group ">
                            <label for="Email">Email</label>
                            <input type="email" class="form-control" id="email" name="email" placeholder="Enter Email" value="{{$registers->email}}" disabled>
                        </div>
                        
                        <div class="form-group ">
                             <label for="Mobile No">Mobile No</label>
                             <input type="text" class="form-control" id="mob_no" name="mob_no" placeholder="Enter Mobile No" value="{{$registers->mobile_number}}">
                        </div>

                        <div class="form-group ">
                             <label for="bbm_pin">BBM Pin</label>
                             <input type="text" class="form-control" id="bbm_pin" name="bbm_pin" placeholder="Enter BBM Pin" value="{{$registers->pin_bbm}}">
                        </div>
                      
                        <div class="form-group ">
                             <label for="url_permalink">Web Url Entry (*)</label>
                             <div class="input-group m-b"><input type="text" class="form-control" id="url_permalink" name="url_permalink" placeholder="Enter Url Entry" value="{{$registers->url_web_contest}}" disabled><a href="{{$registers->url_web_contest}}" class="input-group-addon" title="click view pages" target="_blank"><i class="fa fa-sign-in"></i></a> </div>
                        </div>
                            
                        <hr>    
                        
                        <div class="form-group ">
                          <label for="bank_name">Your Bank Name</label>
                          <select class="form-control m-b" id="bank_name" name="bank_name" required="" autofocus="" aria-required="true">
                              <option value="">-Select Bank Type-</option>
                              @foreach ($bank as $banks) 
                              <option value="{{$banks->id}}" {{ old('bank_name', $banks->id) == @$registers->bank_id ? 'selected': ''  }} >{{$banks->name}}</option>
                              @endforeach    
                          </select> 
                        </div>

                        <div class="form-group ">
                          <label for="acct_no">Your Account Number</label>
                          <input type="text" class="form-control" id="acct_no" name="acct_no" placeholder="Your Account Number" value="{{$registers->account_no}}"> 
                        </div>

                        <div class="form-group ">
                          <label for="bo_acct">On behalf of the Account</label>
                          <input type="text" class="form-control" id="be_acct" name="be_acct" placeholder="On behalf of the Account" value="{{$registers->behalfofaccount}}"> 
                       </div>

                       <hr>

                       <div class="form-group ">
                         <label for="stat">Confirmation Status</label>
                         <select class="form-control m-b" id="stat" name="stat" required="" autofocus="" aria-required="true" @if($registers->verify_status == "0") disabled @endif>
                             <option value="">-Select Confirmation Status-</option>                               
                            @foreach ($status as $statuses) 
                              <option value="{{$statuses->id}}" {{ old('stat', $statuses->status_name) == @$registers->status_name ? 'selected': ''  }} >{{$statuses->status_name}}</option>
                            @endforeach                                    
                         </select> 
                      </div>

                    </form>   
                  </div>
                  <div class="col-lg-12 for-delete" style="display: none;">
                    <form role="form" class="form-horizontal" >
                    {{csrf_field()}}

                      <div class="form-group"><label>Do You want to Delete This Record?</label></div>
                    </form>   
                  </div> 
                  <div class="col-lg-12 for-restore" style="display: none;">
                  <form role="form" class="form-horizontal" method="post">
                  {{csrf_field()}}
                  <div class="form-group"><label>Do You want to Restore This Record?</label></div>
                  </form>   
                  </div> 
                  <div class="col-lg-12 for-movetrash" style="display: none;">
                    <form role="form" class="form-horizontal" method="post">
                    {{csrf_field()}}
                      <div class="form-group"><label>Do You want to Trash This Record?</label></div>
                    </form>   
                  </div>
                  <div class="col-lg-12 for-moveApproved" style="display: none;">
                    <form role="form" class="form-horizontal" method="post">
                    {{csrf_field()}}

                      <div class="form-group"><label>Do You want to Approved This Record?</label></div>
                    </form>   
                  </div>
                  <div class="col-lg-12 for-movePending" style="display: none;">
                    <form role="form" class="form-horizontal" method="post">
                    {{csrf_field()}}                  
                      <div class="form-group"><label>Do You want to Pending This Record?</label></div>
                    </form>   
                  </div>
                  <div class="col-lg-12 for-moveDisqualified" style="display: none;">
                    <form role="form" class="form-horizontal" method="post">
                    {{csrf_field()}}
                     <div class="form-group"><label>Do You want to Disqualified This Record?</label></div>
                    </form>   
                  </div>
                </div>
              </div>    
              <div class="modal-footer form-model-footer">
                <button type="button" id="cancel" class="btn btn-white" data-dismiss="modal">Cancel</button>
                <button type="button" id="upateConstest" class="btn btn-primary updateBanner" data-dismiss="modal" data-id="{{$registers->reg_id}}">Save</button>
                <button type="button" id="deleteConstest" class="btn btn-danger deleteConstest" data-dismiss="modal" data-id="{{$registers->reg_id}}">Delete</button>
                <button type="button" id="btn-moveActionConstest" class="btn btn-primary restoreBanner btn-moveActionConstest" data-dismiss="modal" data-id="{{$registers->reg_id}}" style="display: none;">Restore</button>
                <button type="button" id="btn-moveActionConstest" class="btn btn-danger trashBanner btn-moveActionConstest" data-dismiss="modal" style="display: none;" data-id="{{$registers->reg_id}}" data-action="11" style="display: none;">Move to Trash</button>
                <button type="button" id="btn-moveActionConstest" class="btn btn-warning pendingBanner btn-moveActionConstest" data-dismiss="modal" style="display: none;" data-id="{{$registers->reg_id}}" data-action="6" style="display: none;">Pending</button>
                <button type="button" id="btn-moveActionConstest" class="btn btn-success approvedBanner btn-moveActionConstest" data-dismiss="modal" style="display: none;" data-id="{{$registers->reg_id}}" data-action="7" style="display: none;">Approved</button>
                <button type="button" id="btn-moveActionConstest" class="btn btn-danger disqualifiedBanner btn-moveActionConstest" data-dismiss="modal" style="display: none;" data-id="{{$registers->reg_id}}" data-action="8" style="display: none;">Disqualified</button>
              </div>

            </div>

          </div>

        </div>

      @endforeach 

    <?php 
    
        function addhttpurl($url) {
            if (!preg_match("~^(?:f|ht)tps?://~i", $url)) {
                $url = "http://" . $url;
            }
            return $url;
        }
    
    ?>


@endsection