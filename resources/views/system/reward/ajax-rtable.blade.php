
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
                      @if(!empty($countrylang))
                        @foreach ($countrylang as $rewards)
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
             