       <ol class="dd-list">
          <?php $parent = '0'; ?> 
          
           @foreach ($countrylang as $menus)
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