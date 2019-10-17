@extends('layouts.master')

@section('title', $site_identity->site_title.' | '.ucfirst(substr(Route::currentRouteName(),7)).' Winner ')

@section('breadcrumb')
   
            <h2><i class="fa fa-star"></i> Winner</h2>
            <ol class="breadcrumb">
                   <li>
                        <a href="@if(Auth::user()->account_id !='4' ) /system/admin @else/system/support  @endif ">Dashboard</a>
                   </li>
                   <li class="active">
                       <a href="/system/winner">Winner</a>
                   </li>
                    <li class="active">
                        <strong>{{ucfirst(substr(Route::currentRouteName(),7))}}</strong>
                    </li>
            </ol>

@endsection
@section('admin-content')
            <div class="wrapper wrapper-content clearfix">
                <div class="col-lg-12 "> @include('layouts.messages.messages') 
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
                <div  class="col-lg-12 "> @yield('btn-AddNew') </div>
                <div class="col-lg-12 animated fadeInRight">
                    <div class="row">
                        <div class="col-lg-9">
                            <div class="ibox float-e-margins">
                                <div class="ibox-title">
                                    <h5>{{ucfirst(substr(Route::currentRouteName(),7))}} Winner</h5>
                                </div>
                                <div class="ibox-content">
                                    <p><span><strong>Note:</strong></span> <i>Please Fill the Required Fields</i> <strong class="text-danger"> (*)</strong> </span></p>
                                    <button class="btn btn-outline btn-success pull-right" type="button" id="getContestant" data-toggle="modal" data-target="#registermod"><strong>  Set A Contestant Person </strong></button>
                                    <div class="hr-line-dashed"></div>
                                    <form id="formbanner" role="form" class="form-horizontal">
                                        {{csrf_field()}}
                                         <input type="hidden" name="winners_parent_id" id="winners_parent_id" class="winners_parent_id" value="@yield('winnerid')">
                                        @section('editMethod')
                                        @show
                                        <div class="form-group {{ $errors->has('place') ? 'has-error' : '' }}">
                                            <label>Winner Place<strong class="text-danger"> *</strong></label>
                                            <input type="text" id='place' name='place' placeholder="Winner Place" class="form-control" value="@if(ucfirst(substr(Route::currentRouteName(),7)) =="Create"){{old('place')}}@else @yield('editplace')@endif">
                                            @if($errors->has('place'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('place') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                        <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                                            <label>Name<strong class="text-danger"> *</strong></label>
                                            <input type="text" id='name' name='name' placeholder="Name" class="form-control" value="@if(ucfirst(substr(Route::currentRouteName(),7)) =="Create"){{old('name')}}@else @yield('editname')@endif">
                                            @if($errors->has('name'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('name') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                        <div class="form-group {{ $errors->has('url_win') ? 'has-error' : '' }}">
                                            <label>Url Win<strong class="text-danger"> *</strong></label>
                                            <input type="text" id='url_win' name='url_win' placeholder="Url Win" class="form-control" value="@if(ucfirst(substr(Route::currentRouteName(),7)) =="Create"){{old('url_win')}}@else @yield('editurl_win')@endif">
                                            @if($errors->has('url_win'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('url_win') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                        <div class="form-group">
                                            <label>Proof of Payment</label>
                                            <textarea id='pop' name='pop' rows="5" placeholder="Proof of Payment" class="form-control" >@if(ucfirst(substr(Route::currentRouteName(),7)) =="Create"){{old('pop')}}@else @yield('editpop')@endif</textarea>
                                        </div>  
                                    </form>
                                </div>
                            </div> <!---.ibox-->
                        </div> <!---.col-lg-9-->
                        <div class="col-lg-3">
                            <div class="ibox float-e-margins">
                                <div class="ibox-title">
                                    <h5>Publish</h5>
                                </div>
                                <div class="ibox-content">
                                    <div class="form-group" id="pub-status">
                                        <span><i class="fa fa-key"></i></span> Status: @if(ucfirst(substr(Route::currentRouteName(),7)) =="Create")<span class="badge badge-warning"> Draft </span>  @else @yield('status_info') @endif
                                    </div>
                                    @yield('revision')
                                    <div class="form-group" id="pub-date">
                                        <span><i class="fa fa-calendar-o"></i></span> Date: <strong>@if(ucfirst(substr(Route::currentRouteName(),7)) =="Create") Immediate Publish @else @yield('date_create') @endif</strong>
                                    </div>
                                </div>
                                <div class="ibox-content ibox-heading">
                                    <div class="clearfix">
                                        <input type="hidden" id="winnerid" name="winnerid" value="@yield('winnerid')">
                                        @yield('movetrash')
                                        <button class="btn btn-w-m btn-success pull-right" type="button" id="Saves"><strong> @if(ucfirst(substr(Route::currentRouteName(),7)) =="Create") Save @else Save Changes @endif</strong></button>
                                    </div>
                                </div> <!---.box-content .ibox-heading-->
                            </div> <!---.box .float-e-margins-->

                            @if(Auth::user()->status_id != '4' )

                            <div class="ibox float-e-margins">
                                <div class="ibox-title">
                                    <h5>Category</h5>
                                </div>
                                <div class="ibox-content">
                                    <div class="form-group">
                                        <label>Merchant</label>  
                                        <select class="form-control m-b" id="merchantname" name="merchantname" @if( @$winrecord->merchant_id !='') disabled @endif  >
                                            <option value="">--- Select Merchant ---</option>
                                            @foreach ($merchantlist as $merchants)  
                                                <option value="{{$merchants->merchant_name }}" class="text-center" @if(old('merchantname', $merchants->id) == @$winrecord->merchant_id) selected="selected" @endif> {{str_replace("http://", "",$merchants->merchant_name)}} </option>
                                            @endforeach
                                        </select> 
                                        <div class="lngchoice">
                                        <label>Language</label>    
                                        @php
                                         if(ucfirst(substr(Route::currentRouteName(),7)) =="Create"){ $langid = '1'; }else{ $langid = @$winrecord->lang_id; } 
                                        @endphp
                                        <select class="form-control m-b" id="langname" name="langname" onchange="countrylang(this);" >
                                            <option value="">--- Select Language ---</option>
                                            @foreach ($lang as $langs)  
                                                <option value="{{$langs->id }}" class="text-center" @if(old('merchantname', $langs->id) == @$langid) selected="selected" @endif> {{ $langs->name}} </option>
                                            @endforeach
                                        </select> 
                                        </div>
                                    </div>
                                </div>
                               
                            </div> <!---.box .float-e-margins-->

                            @endif

                        </div> <!---.col-lg-3-->
                    </div> <!---.row-->
                </div> <!---.col-lg-12-->
            </div> <!---.wrapper-->


            <div class="modal fade" id="registermod" tabindex="-1" role="dialog"  aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <!--Modal Content-->
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h3 class="modal-title">Contestant List</h3>
                        </div>
                        <div class="modal-body" >
                            <div class="container-fluid" id="attach_body">
                                <div class="row">
                                  <div class="col-lg-12">   
                                        <div class="pull-right">
                                            <div class="form-group col-md-6">
                                                <label>Merchant</label>  
                                                <select class="form-control m-b" id="merchantnamefilter" name="merchantnamefilter" onchange="merchantfilter(this);"  >
                                                    <option value="">--- Select Merchant ---</option>
                                                    @foreach ($merchantlist as $merchants)  
                                                        <option value="{{$merchants->merchant_name }}" class="text-center" @if(old('merchantnamefilter', $merchants->id) == @$winrecord->merchant_id) selected="selected" @endif> {{str_replace("http://", "",$merchants->merchant_name)}} </option>
                                                    @endforeach
                                                </select> 
                                            </div>
                                            <div id="searchlistname" class="form-group col-md-6">
                                                <label>Search</label>  
                                                <select  id="searchname" name="searchname" data-placeholder="Choose a name..." class="chosen-select form-control m-b" style="width:100%" tabindex="2" onchange="searchfilter(this);"  >
                                                   <option value="">--- Select Contest Name ---</option>
                                                  @if(count($registername)>0)
                                                      @foreach ($registername as $name)
                                                          <option value="{{ucfirst($name->reg_name)}}">{{ucfirst($name->reg_name)}}</option>
                                                      @endforeach
                                                      @else
                                                     
                                                  @endif  
                                                </select>

                                            </div>
                                        </div>
                                   </div> 
                                     <div class="col-lg-12">   
                                       <div class="contest-list">
                                           <table id="constest-tab" class="table table-striped table-bordered table-hover" >
                                               <thead>
                                                   <tr>
                                                       <th>Merchant</th>
                                                       <th>Name</th>
                                                       <th>URL Website Contest</th>
                                                       <th>Language</th>
                                                       <th>Action</th>
                                                   </tr>
                                               </thead>
                                               <tbody>
                                               @if(count($register)>0)
                                                   @foreach ($register as $registers)
                                                       <tr class="gradeX table-item">
                                                           <td>{{str_replace('http://','',$registers->merchants)}}</td>
                                                           <td>{{ucfirst($registers->reg_name)}}</td>
                                                           <td>{{$registers->reg_url}}</td>
                                                           <td data-lagid="{{$registers->langid}}">{{$registers->language}}</td>
                                                           <td><button type="button" id="selectcontestant" class="btn btn-info  dim" data-id="{{$registers->reg_id}}" data-dismiss="modal"><i class="fa fa-copy"></i></button></td>
                                                       </tr>
                                                   @endforeach
                                                   @else
                                                   <tr class='gradeX'>
                                                       <td colspan='5' align="center"><strong>No Record Found</strong></td>
                                                   </tr>
                                               @endif       
                                               </tbody>
                                           </table>
                                           <div id="paginate" name="paginate" class="pull-right">
                                                   {{ $register->links() }}
                                            </div>  
                                       </div><!-- end contest list -->
                                    </div>   
                                   </div>  
                                </div>
                            </div>
                        </div>
                        {{-- <div class="modal-footer">
                            <button type="button" id="selectregister" class="btn btn-primary" data-method="featured_image" data-dismiss="modal">Select</button>
                        </div> --}}
                    </div>
                </div>
            </div>


@endsection