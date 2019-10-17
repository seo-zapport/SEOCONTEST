


<div class="col-lg-5">
    <div class="ibox float-e-margins">
        <div class="ibox-title">
            <h5>Ranking</h5>
        </div>
        <div class="ibox-content">
          <div class="scroll_content">  
            <table class="table table-hover no-margins">
                <thead>
                <tr>
                    <th>Domain</th>
                    <th>Focus Title</th>
                </tr>
                </thead>
                <tbody>
                
                   @if(!empty($merchant_rank))
                        @foreach($merchant_rank as $rank)
                         <tr> 
                          
                             <td><a href="{{$rank->site_url }}" target="_blank" title="Visit this Site" class="btn-link">{{str_replace('http://', '', $rank->site_url)}}/{{strtolower($rank->locale)}}</a></td>
                            <td><button id="btn-rr" type="button" class="btn btn-w-m btn-link btn-sm" data-id="{{$rank->merchants_id}}" >{{$rank->ranking}}</button></td>

                        </tr>
                        @endforeach 
                   @else
                        <tr>
                            <td colspan="2"><strong class="text-center">No Record Found</strong></td>                            
                        </tr>
                   @endif 
                
                </tbody>
            </table>
            </div>
        </div>
    </div>
</div>


  <div class="col-lg-7">
    <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>Google Ranking Result</h5>
            </div>
            <div class="ibox-content">
              <div class="scroll_content_grank">
                    <div class="sk-spinner sk-spinner-three-bounce s-skin-1" style="display: none; margin-top: 15%;">
                       <div class="sk-bounce1"></div>
                       <div class="sk-bounce2"></div>
                       <div class="sk-bounce3"></div>
                    </div> 
                 <div class="google_result" disabled>       
                    <p class="gnotice text-center" style="margin-top: 15%;">Please Click Focus Title to Show Result</p>
                 </div>   
              </div>  
              <hr>
             <span><strong>Note</strong></span>
             <ul class="media-list">
                <li class="media-item"><i class="fa fa-asterisk"></i>If Result Don't Show Their have Some Problem on Connection</li>    
            </ul>
            </div>
    </div>
</div>