

      @if(!empty($countrylang))      
       @foreach ($countrylang as $rewards)
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
    
    