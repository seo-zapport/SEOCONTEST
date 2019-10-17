@extends('layouts.master')

@section('title', $site_identity->site_title.' | Menu')

@section('breadcrumb')
            <h2><i class="fa fa-paint-brush"></i> Menu</h2>
            <ol class="breadcrumb">
                   <li>
                        <a href="@if(Auth::user()->account_id !='4' ) /system/admin @else/system/support  @endif ">Dashboard</a>
                   </li>
                   <li>
                       Apperance
                   </li>
                   <li class="active">
                       <strong class="">Menu</strong>
                   </li>
            </ol>
@endsection

@section('admin-content')

  @if(Auth::user()->status_id != '4' )
    
      <div class="wrapper wrapper-content clearfix">
        <div id="alert_box" class="col-lg-12 ">  @include('layouts.messages.messages')
        <a href="{{url('/system/menu/create')}}" class="btn btn-md btn-primary" style="margin-bottom: 15px;"><i class="fa fa-plus"></i> Add New</a>
        </div>
        <div class="ibox">
          <div class="ibox-title">
            <h5>Menu List</h5>
          </div>
          <div class="tabs-container ibox-content">
                  <div id="Menu-Items">
                      <div class="row">
                          <div class="col-lg-6">
                          </div> <!---.col-lg-12-->
                          <div class="col-md-3 pull-right">
                              <!-- Search box  -->        
{{--                               <form role="form" class="form-horizontal pull-right"  method="get" >
                                  <div class="input-group">
                                      <div class="input-group-btn">
                                          <button id="searchnow" type="submit" class="btn btn-primary searchnow"> Search </button>
                                      </div>
                                      <input type="text" class="form-control" id="search" name="search" placeholder="Search for ...">
                                  </div>
                              </form> --}}
                          </div> 
                      </div> <!---.row-->
                      <div class="row">
                          <div class="col-md-5">
{{--                               <form role="form" class="form-horizontal col-lg-5" method="post"> 
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
                              </form> --}}
                          </div>
                          <div class="col-md-3 pull-right">
                              <!--<p class="badge badge-info"><span>{{ @$page_count }}</span> Item(s)</p>-->
                          {{--       @if(!empty(app('request')->input('search')))  
                                   Search results for <strong>"{{app('request')->input('search')}}"</strong>
                               @endif  --}}
                          </div>
                      </div> <!---.row-->
                      <br>
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
                                      <th>Menu Title</th>
                                      <th>Merchant</th>
                                      <th>Author</th>
                                      <th>Date</th>
                                      <th style="width:5%">Header Primary</th>
                                      <th style="width:5%">Footer Primary</th>
                                      <th>Action</th>
                                  </tr>
                              </thead>
                              <tbody>
                              @if(count($menulist)>0)
                                  @foreach ($menulist as $menu)
                                      <tr class="gradeX table-item">
                                          <td class="text-center">
                                            <div class="checkbox checkbox-primary rows">
                                                <input type="checkbox" class="styled styled-primary" id="pagesarr" name="pagesarr[]" value="{{$menu->id}}" >
                                                <label></label>
                                            </div>
                                          </td>
                                          <td><strong>{{ucfirst($menu->menu_name)}}  @if($menu->status_id == '12') <span class="text-center">--Draft</span> @endif</strong></td>
                                           <td>{{str_replace('http://','',$menu->merchant_name)}}</td>
                                          <td>{{$menu->display_name}}</td>
                                          <td>{{$menu->created_at->format('F d, Y')}}</td>
                                          <td style="width:5%">@if($menu->default_id == "1") <span class="btn btn-primary dim" type="button"><i class="fa fa-check"></i></span>@else<span class="btn btn-danger dim" type="button"><i class="fa fa-close"></i></span> @endif</td>
                                          <td style="width:5%">@if($menu->footer_d_id == "1") <span class="btn btn-primary dim" type="button"><i class="fa fa-check"></i></span>@else<span class="btn btn-danger dim" type="button"><i class="fa fa-close"></i></span> @endif</td>
                                          <td>
                                            @if($menu->status_id == '11')
                                              <span><a href="#" class="modalRestore" data-hover="tooltip" data-placement="top"  data-toggle="modal"  data-target="#ViewStatus-{{$menu->id}}" title="Restore"><button class="btn btn-success  dim" type="button"><i class="fa fa-refresh"></i></button><input type="hidden" id="Restoreid" name="Restoreid" value="{{$menu->id}}"></a></span>
                                              {{-- <span><a href="#" class="modalDelete text-danger" data-hover="tooltip" data-placement="top"  data-toggle="modal"  data-target="#ViewStatus-{{$menu->id}}" title="Delete"><button class="btn btn-danger  dim " type="button"><i class="fa fa-trash"></i></button><input type="hidden" id="Delid" name="Delid" value="{{$menu->id}}"></a></span> --}}
                                            @else
                                              <span><a href="{{'/system/menu/'.$menu->id.'/edit'}}" class="text-info" title="Edit"><button class="btn btn-info  dim" type="button"><i class="fa fa-paste"></i> </button></a></span>
                                              {{-- <span><a href="#" class="modalTrash text-danger" data-hover="tooltip" data-placement="top"  data-toggle="modal"  data-target="#ViewStatus-{{$menu->id}}" title="Move To Trash"><button class="btn btn-danger  dim " type="button"><i class="fa fa-trash"></i></button><input type="hidden" id="Trashid" name="Trashid" value="{{$menu->id}}"></a></span> --}}
                                            @endif
                                          </td>
                                      </tr>
                                  @endforeach
                                  @else
                                  <tr class='gradeX'>
                                      <td colspan='5' align="center"><strong>No Record Found</strong></td>
                                  </tr>
                              @endif       
                              </tbody>
                          </table>
                      </div> <!---.table-responsive-->
                      <div id="paginate" name="paginate">
                          {{ $menulist->links() }}
                      </div>  
                  </div> <!---#page-Items-->
      </div>
    </div>
    </div>


  @else
    <div class="row">
        <div class="wrapper wrapper-content">
          <div class="panel blank-panel">
            <div class="panel-heading">
              <div class="panel-options">
                <ul class="nav nav-tabs">
                  <li class="active"><a data-toggle="tab" href="#tab-1">Edit Menu</a></li>
                  <li><a data-toggle="tab" href="#tab-2">Manage Menu</a></li>
                </ul>
              </div>
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
                    </form>
                  </div>
                </div> <!--.ibox-->
                <div id="Menu" class="row">
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
                                                <input type="checkbox" class="check-item check page-check" value="{{ $pages->page_title }}" data-id="{{ $pages->id }}" @if(empty($menu)) disabled @endif>  
                                                {{ $pages->page_title }}
                                                </label>
                                              </li>
                                            @endforeach
                                          @endif 
                                        </ul> <!--.list-group-->
                                      </div> <!--.scroll_content-->
                                    </div> <!--.panel-body-->
                                  </div> <!--.panel-default--> 
                                  <div class="clearfix" style="margin-top: 18px;">
                                    <button id="AddMenus" class="btn btn-default pull-right m-t-n-xs" type="button" data-options = "pages"  @if(empty($menu)) disabled @endif><strong>Add Menu</strong></button>
                                        <label><a class="i-checks selectAll" id="selectAllPages" data-check = "no" >Select All </a></label>
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
                                          <label class="control-label col-sm-3" for="email">Url:</label>
                                          <div class="col-sm-9">
                                            <input type="email" id="email" name="email" placeholder="" class="form-control" @if(empty($menu)) disabled @endif>
                                          </div>
                                        </div>
                                        <div class="form-group">
                                          <label class="control-label col-sm-3" for="email">Link Text:</label>
                                          <div class="col-sm-9">
                                            <input type="text" id="url_title" name="url_title" placeholder="" class="form-control" @if(empty($menu)) disabled @endif>
                                          </div>
                                        </div>
                                        <div class="form-group" style="margin-bottom: 0;">        
                                          <div class="col-md-12">
                                            {{-- <button type="submit" class="btn btn-default">Submit</button> --}}
                                            <button id="AddCustomMenus" class="btn btn-default pull-right m-t-n-xs @if(empty($menu)) disabled @endif" type="button" onclick="AddCustomMenu()"><strong>Add Menu</strong></button> 
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
                      </div> <!--#accordion-->
                    </div> <!--.panel-body-->
                  </div> <!--.col-md-4-->
                  <div class="col-md-9">
                    <div class="ibox float-e-margins">
                      <div class="ibox-title clearfix" style="height: auto; padding: 12px 15px 12px;">
                           <form role="form" class="form-inline">
                            {{csrf_field()}}
                            <div class="form-group">
                              <label >Menu Name</label>
                            @if(!empty($menu))
                                <input type="name" id="menu_name" class="form-control input-sm" value="{{$menu->menu_name}}">
                            </div>
                            <button id="CreateMenu" class="btn btn-success btn-sm pull-right" type="button" ><strong>Save Changes</strong></button>
                            @else  
                              <input type="name" id="menu_name" class="form-control input-sm" value="">
                            </div>
                            <button id="AddNewMenu" class="btn btn-success btn-sm pull-right" type="button" ><strong>Create Menu</strong></button>
                            @endif                           
                          </form>
                      </div>  <!--.ibox-title-->
                      <div class="ibox-content">
                        @if(!empty($menu_setup))
                          <h1>Menu Structure</h1>
                          <p class="m-b-lg">Drag each item into the order you prefer. Click the arrow on the right of the item to reveal additional configuration options.</p>
                          <div class="dd" id="nestable">
                            <ol class="dd-list">
                              @php
                                 $parent = '0';
                              @endphp
                              @foreach($menu_setup as $menus)
                                <li class="dd-item" data-id="{{$menus->id}}">
                                  <div class="dd-handle">
                                       {{ucfirst($menus->label)}}
                                    <label class="pull-right" style="margin-top: -7px;">
                                      <a id="EditMenu" href="#" class="btn btn-sm btn-link EditMenu text-success" data-hover="tooltip" data-placement="top"  data-toggle="modal"  data-target="#ViewStatus-{{$menus->id}}" ><i class="fa fa-edit"></i><input type="hidden" id="ms_eid" name="ms_eid" value="{{$menus->id}}"></a> 
                                      <form style="display: inline-block;" method="post" action="{{'/system/menu/'.$menus->id}}" >
                                        {{csrf_field()}}
                                        {{method_field('DELETE')}}
                                        <button type="submit" class="btn btn-w-s btn-link text-danger"><i class="fa fa-trash"></i></button>
                                      </form> 
                                    </label>
                                  </div>
                                  @foreach ($menus->children as $children)
                                    <ol class="dd-list">
                                      <li class="dd-item" data-id="{{$children->id}}">
                                        <div class="dd-handle">{{ucfirst($children->label)}} 
                                          <label class="pull-right" style="margin-top: -7px;">                                            
                                            <a id="EditMenu" href="#" class="btn btn-sm btn-link EditMenu text-success" data-hover="tooltip" data-placement="top"  data-toggle="modal"  data-target="#ViewStatus-{{$children->id}}" ><i class="fa fa-edit"></i><input type="hidden" id="ms_eid" name="ms_eid" value="{{$children->id}}"></a> 
                                            <form style="display: inline-block;" method="post" action="{{'/system/menu/'.$menus->id}}" >
                                              {{csrf_field()}}
                                              {{method_field('DELETE')}}
                                              <button type="submit" class="btn btn-w-s btn-link text-danger"><i class="fa fa-trash"></i></button>
                                            </form> 
                                          </label>
                                        </div>
                                      </li>
                                    </ol> <!--.dd-list-->
                                  @endforeach
                                </li> <!--.dd-item-->
                              @endforeach
                            </ol> <!--.dd-list-->
                          </div> <!--.dd-->
                        @else 
                          <p class="m-b-lg">Give your menu a name, then click Create Menu. </p>    
                        @endif
                        <div>
                          <hr>
                          <form class="form-inline">
                            <div class="form-group">
                              <label>
                                <input type="checkbox" class="check-item-prim check" @if(!empty($menu->default_id)) @if($menu->default_id==1) checked @endif @endif> Set As Primary Menu
                              </label>
                            </div>
                          </form> <!--Set-as-primary-->           
                          <form class="form-inline">
                            <div class="form-group">
                              <label>
                                <input type="checkbox" class="check-item-pri-ft check" @if(!empty($menu->footer_d_id)) @if($menu->footer_d_id==1) checked @endif @endif> Set As Footer Menu
                              </label>
                            </div>
                          </form> <!--Set-as-primary-->                 
                        </div>
                      </div>  <!--.ibox-content-->
                      <div class="ibox-content ibox-heading">
                        <div class="row">
                          @if(!empty($menu))  
                            <form>                                 
                              <input type="hidden" id="menu_ids" name="menu_ids" value="{{$menu->id}}">
                              <button type="button" id="DeleteMenus" class="btn btn-w-m btn-link pull-left btn-sm text-danger"><i class="fa fa-trash"></i> Delete</button> 
                            </form> 
                            <button id="CreateMenu" class="btn btn-success btn-sm pull-right" type="button" ><strong>Save Changes</strong></button>  
                          @else         
                            <button id="AddNewMenu" class="btn btn-success btn-sm pull-right" type="button" ><strong>Create Menu</strong></button>
                          @endif
                        </div> 
                      </div> <!--.ibox-footer-->
                    </div>  <!--.ibox-->
                  </div> <!--.col-md-8-->
                </div> <!--#tab-2-->
              </div> <!--#Menu-->
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
                                                if(!empty($default)){
                                                  if($default->def_id){
                                                    $url = "/system/menu/".$default->def_id."/edit";
                                              @endphp
                                                     <a href="{{$url}}" class="btn btn-w-m btn-link" type="button" ><strong>Edit</strong></a>
                                              @php }
                                                  } @endphp     
                                             | <a href="{{ url('/system/menu/create') }}" class="btn btn-w-m btn-link" type="button" ><strong>Use New Menu</strong></a>
                                         </div>
                                         </div>  
                                       </td>
                                     </tr>
                                     <tr>
                                       <td>Footer Menu</td>
                                        <td class="col-sm-7">
                                         <div class="input-group">
                                         <select class="form-control col-sm-6" id="ftprimenu" name="ftprimenu">
                                             <option value="" class="text-center">-Select Menu- </option>p
                                             @if(!empty($menuAll))
                                               @foreach ($menuAll as $menuAlls)  
                                                 <option value="{{$menuAlls->id}}"  @if(old('ftprimenu', $menuAlls->footer_d_id) == 1) selected @endif >{{$menuAlls->menu_name}}</option>
                                               @endforeach
                                             @endif
                                         </select> 
                                         <div class="input-group-btn">
                                              @php
                                                if(!empty($default)){
                                                  if($default->ft_def_id){
                                                    $url = "/system/menu/".$default->ft_def_id."/edit";
                                              @endphp
                                                     <a href="{{$url}}" class="btn btn-w-m btn-link" type="button" ><strong>Edit</strong></a>
                                              @php } 
                                                  } @endphp     
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
              </div> <!--#tab-2-->
            </div> <!--.panel-body-->
          </div> <!--.blank-panel-->
        </div> <!--.wrapper-->
    </div> <!--.row-->

  @if(!empty($menu_setup)) 
    <div class="msmodal">
          @foreach($menu_setup as $menus)
              <div class="modal inmodal fade" id="ViewStatus-{{$menus->id}}" tabindex="-1" role="dialog"  aria-hidden="true">
                <div class="modal-dialog modal-m">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                            <h4 class="modal-title" id="modal-title">{{$menus->label}} [Edit Menu]</h4>
                        </div>
                        <div class="modal-body">
                            <input type="hidden" id="msid" name="msid[]" class="msid" >
                            <div class="container-fluid">
                                <div class="col-lg-12 for-edit">
                                <form id="formMenu" role="form" class="form-horizontal" method="post" >
                                {{csrf_field()}}

                                    @if($menus->custom_menu>0)
                                    <div class="form-group"><label>Url</label> <input type="text" id='Url_{{$menus->id}}' name='Url_{{$menus->id}}' class="form-control" value="{{$menus->link}}"></div>
                                    @endif

                                    <div class="form-group"><label>Navigation Label</label> <input type="text" id='Label_{{$menus->id}}' name='Label_{{$menus->id}}' class="form-control" value="{{$menus->label}}"></div>

                                    <div class="form-group"><label>Title Attribute</label> <input type="text" id='title_attrib_{{$menus->id}}' name='title_attrib_{{$menus->id}}'  class="form-control" value="{{$menus->title_attrib}}"></div> 
                                    
                                    <div class="form-group col-lg-6"><input type="checkbox" id='tab_status_{{$menus->id}}' name='tab_status_{{$menus->id}}' class="form-control" @if($menus->tab_status > 0) checked @endif> <label>Open link in a new tab</label> </div> 

                                    <div class="form-group col-lg-6 pull-right"><input type="checkbox" id='modal_pop_{{$menus->id}}' name='modal_pop_{{$menus->id}}' class="form-control" @if($menus->pop_m > 0) checked @endif> <label>Open in Pop-Up Modal</label> </div> 

                                    <div class="form-group col-lg-6"><label>Css Class (optional)</label> <input type="text" id='css_class_{{$menus->id}}' name='css_class_{{$menus->id}}'  class="form-control" value="{{$menus->css_class}}"></div>

                                    <div class="form-group col-lg-6 pull-right"><label>Link Relation (XFN)</label> <input type="text" id='link_rel_{{$menus->id}}' name='link_rel_{{$menus->id}}'  class="form-control" value="{{$menus->link_rel}}"></div>

                                    <div class="form-group"><label>Description</label><textarea id='description_{{$menus->id}}' name='description_{{$menus->id}}' rows="10" placeholder="Description" class="form-control">{{$menus->description}}</textarea></div> 

                                </form>   
                                </div> 
                            </div>
                        </div>    
                        <div class="modal-footer">
                          <button type="button" id="cancel" class="btn btn-white" data-dismiss="modal">Cancel</button>
                          <button type="button" id="UpdateMS" class="btn btn-primary UpdateMS" data-dismiss="modal">Save Changes</button>
                        </div>
                        </div>
                    </div>
            </div>
          @endforeach
    </div>  
  @endif

  @endif






@endsection



                        