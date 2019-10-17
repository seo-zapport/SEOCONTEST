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
                                  