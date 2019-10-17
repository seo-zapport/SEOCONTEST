@extends('system.appearance.menu.create')

@section('menu_name', $menu->menu_name)
@section('merchantdef', $menu->merchants_id)

@section('editBtnUpdate')
    <button id="CreateMenu" class="btn btn-success pull-right" type="button"><strong>Save Changes</strong></button>
@endsection

@section('AddMenu')

    @if(!empty($menu_setup))  
      <h1>Menu Structure</h1>
      <p class="m-b-lg">
        Drag each item into the order you prefer. Click the arrow on the right of the item to reveal additional configuration options.
      </p>

    <div class="dd" id="nestable">
         <ol class="dd-list">
          <?php $parent = '0'; ?> 
          
           @foreach ($menu_setup as $menus)
            @if($menus->parent_id == $parent)
            <li class="dd-item" data-id="{{$menus->id}}">
                <div class="dd-handle">
                        {{$menus->label}}
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
                       <div class="dd-handle">{{$children->label}} 
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
                 </ol>
               @endforeach
            
            </li>
          @endif
     @endforeach
      </ol>
      </div>
    @endif
@endsection

@section('brandmenus')
{{-- 	@if(count($brand)>0)  
	    @foreach ($brand as $brands)  
	      <option value="{{$brands->id}}"  @if(old('brandmenu', $brands->id) == @$menu->brand_id) selected="selected" @endif >{{$brands->brand_name}}</option>
	    @endforeach
	  @endif --}}
@endsection

@section('editmenu_ids')
<form>
    <input type="hidden" id="menu_ids" name="menu_ids" value="{{$menu->id}}">
    <button type="button" id="DeleteMenus" class="btn btn-w-m btn-link pull-left text-danger" onclick="DeleteMenu()" ><i class="fa fa-trash"></i>Delete</button> 
</form>
@endsection


@section('modal_menusetup')
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

                                @if($menus->custom_menu > 0 )
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
@endsection

@section('editMethod')
    {{method_field('PUT')}}
@endsection


