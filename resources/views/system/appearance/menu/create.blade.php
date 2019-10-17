@extends('layouts.master')

@section('title', $site_identity->site_title.' | Menu')

@section('breadcrumb')
            <h2><i class="fa fa-paint-brush"></i> Menu</h2>
            <ol class="breadcrumb">
                   <li>
                        <a href="@if(Auth::user()->account_id !='4' ) /system/admin @else/system/support  @endif ">Dashboard</a>
                   </li>
                   <li>
                        <a href="{{ url('/system/menu') }}">Apperance</a>
                   </li>
                   <li class="active">
                       <strong>Menu</strong>
                   </li>
            </ol>
@endsection

@section('admin-content')
  <div class="row">
      <div class="wrapper wrapper-content">
        <div class="panel blank-panel">
          <div class="panel-heading">
            <div class="panel-options">
              <ul class="nav nav-tabs">
                <li class="active"><a data-toggle="tab" href="#tab-1">Edit Menu</a></li>
                <li class=""><a data-toggle="tab" href="#tab-2">Menu List</a></li>
              </ul> <!--.nav-->
            </div> <!--.panel-options-->
          </div> <!--.panel-heading-->
          <div class="panel-body tab-content">
            <div id="tab-1" class="tab-pane active">
              <div class="ibox float-e-margins">
                <div class="wrapper border-bottom white-bg page-heading" style="border: 1px solid #e7eaec; padding: 10px;">
                  <form role="form" class="form-inline">
                    {{csrf_field()}}
                    <div class="form-group">
                      <label> Select a menu to edit:</label>
                      <select class="form-control" id="selmenu" name="selmenu"  >
                          <option value="" class="text-center">-Select Menu- </option>
                          @if(!empty($menuAll))
                            @foreach ($menuAll as $menuAlls)  
                              <option value="{{$menuAlls->id}}"  @if(old('selmenu', $menuAlls->id) == @$menu->id) selected="selected" @endif >{{$menuAlls->menu_name}}</option>
                            @endforeach
                          @endif
                      </select>
                      <button id="selectgo" class="btn btn-sm btn-outline btn-default" type="button" onclick="EditGo()">Select</button>
                    </div>
                    <span style="margin-left: 10px;font-weight: 600;">or</span>
                    <a href="{{ url('/system/menu/create') }}" id="NewMenu" class="btn btn-link text-success" type="button">Create New Menu</a>
                  
                    <div class="pull-right">
                      <select class="form-control m-b" id="langname" name="langname" onchange="countrylang(this);"  @if(ucfirst(substr(Route::currentRouteName(),6)) =="Create") disabled @endif>
                          <option value="">--- Select Language ---</option>
                          @foreach ($lang as $langs)  
                              <option value="{{$langs->id }}" class="text-center" @if(old('merchantname', $langs->id) == @$langdef[0]->lang_id) selected="selected" @endif > {{ $langs->name}} </option>
                          @endforeach
                      </select>        
                    </div>


                  </form>
                </div>
              </div> <!--.ibox-->
              <div class="row">
                <div class="col-md-3">
                  <div class="panel-body" style="padding: 0 0px 15px 0px;">
                    <div class="panel-group" id="accordion">
                      <div class="panel panel-default">
                        <div class="panel-heading">
                          <h5 class="panel-title"><a data-toggle="collapse" data-parent="#accordion" href="#Pages">Pages</a></h5>
                        </div> <!--.panel-heading-->
                        <div id="Pages" class="panel-collapse collapse in">
                          <div class="panel-body">
                            <div class="row">
                              <div class="col-lg-12">
                                <div class="panel panel-default">
                                  <div class="panel-body">
                                    <div class="scroll_content" >
                                      <ul class="list-group">
                                        @if(!empty($page))
                                          @foreach ( $page as $pages )
                                            <li class="list-group-select">
                                              <label for="list_item_{{ $pages->id }}">
                                              <input type="checkbox" class="check-item check page-check" value="{{ $pages->page_title }}" data-id="{{ $pages->id }}" @if(ucfirst(substr(Route::currentRouteName(),5)) =="Create") disabled @endif> 
                                              {{ $pages->page_title }} @if(Auth::user()->status_id !='4') - {{str_replace('http://', '',$pages->merchant_name)}} @endif
                                              </label>
                                            </li>
                                          @endforeach
                                        @endif  
                                      </ul> <!--.list-group-->
                                    </div> <!--.scroll_content-->
                                  </div> <!--.panel-body-->
                                </div> <!--.panel .panel-default-->
                                <div class="clearfix" style="margin-top: 18px;">
                                  <button id="AddMenus" class="btn btn-default pull-right m-t-n-xs  @if(ucfirst(substr(Route::currentRouteName(),5)) =="Create") disabled @endif" type="button" data-options = "pages"><strong>Add Menu</strong></button>
                                  <label><a class="i-checks selectAll" id="selectAllPages" data-check = "no">Select All </a></label>
                                </div>
                              </div> <!--.col-lg-12-->
                            </div> <!--.row-->
                          </div> <!--.panel-body-->
                        </div> <!--#Pages-->
                      </div> <!--.panel-default-->

                      <div class="panel panel-default">
                        <div class="panel-heading">
                          <h5 class="panel-title"><a data-toggle="collapse" data-parent="#accordion" href="#CutomLink">Custom Link</a></h5>
                        </div> <!--.panel-heading-->
                        <div id="CutomLink" class="panel-collapse collapse">
                          <div class="panel-body">
                            <div class="row">
                              <div class="col-lg-12">
                                <div class="panel-body">
                                  <form id="formCustomAdd" role="form" class="form-horizontal">
                                    {{csrf_field()}}
                                    <div class="row">
                                      <div class="form-group">
                                        <label class="control-label col-sm-3" for="add_url">Url:</label>
                                        <div class="col-sm-9">
                                          <input type="text" id="add_url" name="add_url" placeholder="" class="form-control"  @if(ucfirst(substr(Route::currentRouteName(),5)) =="Create") disabled @endif>
                                        </div>
                                      </div>
                                      <div class="form-group">
                                        <label class="control-label col-sm-3" for="email">Link Text:</label>
                                        <div class="col-sm-9">
                                          <input type="text" id="url_title" name="url_title" placeholder="" class="form-control"  @if(ucfirst(substr(Route::currentRouteName(),5)) =="Create") disabled @endif>
                                        </div>
                                      </div>
                                      <div class="form-group" style="margin-bottom: 0;">        
                                        <div class="col-md-12">
                                          <button id="AddCustomMenus" class="btn btn-default pull-right m-t-n-xs  @if(ucfirst(substr(Route::currentRouteName(),5)) =="Create") disabled @endif" type="button"><strong>Add Menu</strong></button>
                                        </div>
                                      </div>
                                      </div>
                                  </form>
                                </div> <!--.panel-body-->
                              </div> <!--.col-lg-12-->
                            </div> <!--.row-->
                          </div> <!--.panel-body-->
                        </div> <!--#Pages-->
                      </div> <!--.panel-default-->
                    </div> <!--.panel-group-->
                  </div> <!--.panel-body-->
                </div> <!--.col-md-3-->
                <div class="col-md-9">
                  <div class="ibox float-e-margins">
                    <div class="ibox-title clearfix" style="height: auto; padding: 12px 15px 12px;">
                      <form role="form" class="form-inline">
                      {{csrf_field()}}
                        <div class="form-group">
                          <label >Menu Name</label>
                          <input type="name" id="menu_name" class="form-control input-sm" value="@yield('menu_name')"> 
                        </div>
                        @if(ucfirst(substr(Route::currentRouteName(),5)) =="Create")
                          {{-- <button id="AddNewMenu" class="btn btn-success btn-sm pull-right" type="button" onclick="Newmenu()"><strong>Create Menu</strong></button> --}}
                          <button id="AddNewMenu" class="btn btn-success btn-sm pull-right" type="button" ><strong>Create Menu</strong></button>
                        @else
                          @yield('editBtnUpdate')
                        @endif
                      </form>
                    </div> <!--.ibox-title-->
                    <div class="ibox-content">
                      @if(ucfirst(substr(Route::currentRouteName(),5)) =="Create")
                         <p class="m-b-lg"> Give your menu a name, then click Create Menu. </p>
                      @else
                          @yield('AddMenu')
                      @endif
                      <hr>
                      <div>
                        @if(Auth::user()->status_id != '4' )
                          <form class="form-inline">
                            <div class="form-group">
                              <label>Merchant </label>
                                  <select class="form-control" id="selbrand" name="selbrand"  >
                                  <option value="" class="text-center">-Select Merchant- </option>
                                  @if(!empty($merchantlist))
                                  @foreach ($merchantlist as $merchantlists)  
                                  <option value="{{$merchantlists->merchant_name}}" @if(old('selbrand', $merchantlists->id) == @$menu->merchants_id ) selected @endif>{{str_replace("http://" ,"", $merchantlists->merchant_name)}}</option>
                                  @endforeach
                                  @endif
                                  </select>
                            </div>
                          </form> <!--Set-as-primary--> 
                          <hr>          
                        @endif

                        <form class="form-inline">
                          <div class="form-group">
                            <label>
                              <input type="checkbox" class="check-item-prim check" @if(ucfirst(substr(Route::currentRouteName(),5)) !="Create") @if(!empty($menu->default_id)) @if($menu->default_id==1) checked @endif @endif @endif> Set As Primary Menu
                            </label>
                          </div>
                        </form> <!--Set-as-primary-->           
                        <form class="form-inline">
                          <div class="form-group">
                            <label>
                              <input type="checkbox" class="check-item-pri-ft check" @if(ucfirst(substr(Route::currentRouteName(),5)) !="Create") @if(!empty($menu->footer_d_id)) @if($menu->footer_d_id==1) checked @endif @endif @endif> Set As Footer Menu
                            </label>
                          </div>
                        </form> <!--Set-as-primary-->           
                      </div>
                    </div> <!--.ibox-content-->
                    <div class="ibox-content ibox-heading">
                      <div class="row">
                        @if(ucfirst(substr(Route::currentRouteName(),5)) =="Create")
                          <button id="AddNewMenu" class="btn btn-success btn-sm pull-right" type="button" onclick="Newmenu()"><strong>Create Menu</strong></button>
                        @else
                            @yield('editmenu_ids')
                            @yield('editBtnUpdate')
                        @endif
                      </div> 
                    </div> <!--.ibox-footer-->
                  </div> <!--.ibox-->
                </div> <!--.col-md-9-->
              </div>
            </div> <!--#tab-1-->
            <div id="tab-2" class="tab-pane">
              <div class="row">
                <div class="col-lg-7 animated fadeInRight">
                  <div class="row">
                    <div class="col-lg-12">
                      <div class="ibox float-e-margins">
                        <div class="ibox-title">
                          <h5>Theme Location</h5>
                        </div>
                        <div class="ibox-content clearfix">
                          <div id="menu_list">
                            <div id="menu_list">
                              <form id="menulocation">
                                  {{csrf_field()}}
                                 <table>
                                   <thead></thead>
                                   <tbody>
                                     <tr>
                                       <td>Primary Menu</td>
                                       <td class="col-sm-7">
                                         <div class="input-group">
                                         <select class="form-control col-sm-6" id="primenu" name="primenu">
                                             <option value="" class="text-center">-Select Menu- </option>
                                             @if(!empty($menuAll))
                                               @foreach ($menuAll as $menuAlls)  
                                                 <option value="{{$menuAlls->id}}"  @if(old('primenu', $menuAlls->default_id) == 1) selected @endif >{{$menuAlls->menu_name}}</option>
                                               @endforeach
                                             @endif
                                         </select> 
                                         <div class="input-group-btn">
                                              @php
                                                 if(!empty($default) ) {
                                                  if($default->def_id){
                                                    $url = "/system/menu/".$default->def_id."/edit";
                                              
                                              @endphp
                                                     <a href="{{$url}}" class="btn btn-w-m btn-link" type="button" ><strong>Edit</strong></a>
                                              
                                              @php  }
                                                  }
                                               @endphp     
                                             | <a href="{{ url('/system/menu/create') }}" class="btn btn-w-m btn-link" type="button" ><strong>Use New Menu</strong></a>
                                         </div>
                                         </div>  
                                       </td>
                                     </tr>
                                     <tr>
                                       <td>Footer Menu</td>
                                        <td class="col-sm-7">
                                         <div class="input-group">
                                         <select class="form-control col-sm-6" id="priftmenu" name="priftmenu">
                                             <option value="" class="text-center">-Select Menu- </option>
                                             @if(!empty($menuAll))
                                               @foreach ($menuAll as $menuAlls)  
                                                 <option value="{{$menuAlls->id}}"  @if(old('priftmenu', $menuAlls->footer_d_id) == 1) selected @endif >{{$menuAlls->menu_name}}</option> 
                                               @endforeach
                                             @endif
                                         </select> 
                                         <div class="input-group-btn">
                                              @php
                                                if(!empty($default) ){ 
                                                  if($default->ft_def_id){
                                                    $url = "/system/menu/".$default->ft_def_id."/edit";
                                              @endphp
                                                     <a href="{{$url}}" class="btn btn-w-m btn-link" type="button" ><strong>Edit</strong></a>
                                              @php }
                                                  }
                                                 @endphp     
                                             | <a href="{{ url('/system/menu/create') }}" class="btn btn-w-m btn-link" type="button" ><strong>Use New Menu</strong></a>
                                         </div>
                                         </div>  
                                       </td>
                                     </tr>
                                   </tbody>
                                 </table>

                                <div class="form-group">
                                  <button id="SaveDefaultMenu" class="btn btn-success btn-sm" type="button" ><strong>Save Changes</strong></button>
                                </div>
                              </form>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div> <!--#tab-2-->
          </div> <!--.tab-content-->
        </div> <!--.blank-panel-->
      </div> <!--.wrapper-->
  </div> <!--.row-->
  @yield('modal_menusetup')
@endsection



                