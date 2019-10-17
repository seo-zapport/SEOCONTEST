<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\cseo_winrecord;
use App\cseo_team;
use App\cseo_merchant;
use App\cseo_options_settings;
use App\cseo_statuses;
use App\cseo_account;
use App\cseo_register;

use DB;
use URL;
use Validator;
use Redirect;


class WinController extends Controller
{

     public $user;      
    /**
        * Create a new controller instance.
        *
        * @return void
        */
       public function __construct()
       {
           $this->middleware('auth');
           $this->middleware('logged'); 

           $this->middleware(function ($request, $next) {

             $this->user = cseo_account::where('id',  auth()->user()->id)->first();
             
             if($this->user->status_id == '1' || $this->user->status_id == '4'){
                 return $next($request); 
             }else{
                 return redirect('/403');
             }

         });
       }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        $winrecord = new cseo_winrecord;

        $merchant = cseo_merchant::where('merchant_name', URL::to('/'))->first();

        $title = cseo_options_settings::SELECT('site_identity')->where('merchants_id', $merchant->id)->first();

               if ( count( $title ) > 0 ) {
                   $site_identity = json_decode( $title->site_identity);
               }


        $cseo_wincount = $winrecord->SELECT(DB::raw("(SELECT count(*) from cseo_winrecords where lang_id = '2') countAll, (SELECT count(*) from cseo_winrecords where lang_id = '2' and status_id ='9') countPublished, (SELECT count(*) from cseo_winrecords where status_id = '11' and lang_id ='2') countTrash,(SELECT count(*) from cseo_winrecords where status_id = '10' and lang_id ='2') countUnpublished"))->first();


        $query = [];
        $searchwin = ['cseo_winrecords.name','cseo_merchants.merchant_name', 'cseo_winrecords.url_win', 'cseo_statuses.id' ];    

        if(request()->has('search') && request()->has('status_id')){            

         $search = request('search');    
         $statusid = request('status_id');    
         
          $winrecord = $winrecord->SELECT('cseo_winrecords.id as wins_id','cseo_winrecords.name','cseo_winrecords.url_win','cseo_winrecords.win_place','cseo_winrecords.status_id','cseo_winrecords.pop','cseo_winrecords.created_at','cseo_statuses.status_name', 'cseo_merchants.merchant_name');

          foreach ($searchwin as $searchwins) {
                   $winrecord->orwhere($searchwins,'like', "%".$search."%")->where('cseo_winrecords.status_id',$statusid)->where('cseo_winrecords.lang_id', '2');
            }

          $winrecord->join('cseo_statuses','cseo_statuses.id', '=', 'cseo_winrecords.status_id')->join('cseo_merchants', 'cseo_merchants.id','=','cseo_winrecords.merchant_id')->orderBy('cseo_winrecords.win_place','asc')->latest();  

          $query['search'] = request('search'); 
          $query['status_id'] = request('status_id'); 
        

         }elseif(request()->has('status_id')){
        
           $winrecord = $winrecord->SELECT('cseo_winrecords.id as wins_id','cseo_winrecords.name','cseo_winrecords.url_win','cseo_winrecords.win_place','cseo_winrecords.status_id','cseo_winrecords.pop','cseo_winrecords.created_at','cseo_statuses.status_name', 'cseo_merchants.merchant_name')->join('cseo_statuses','cseo_statuses.id', '=', 'cseo_winrecords.status_id')->join('cseo_merchants', 'cseo_merchants.id','=','cseo_winrecords.merchant_id')->where('cseo_winrecords.status_id', request('status_id'))->where('cseo_winrecords.lang_id', '2')->orderBy('cseo_winrecords.win_place','asc')->latest();    
           
           $query['status_id'] = request('status_id');


         }elseif(request()->has('search')){

              $search = request('search');    

              $winrecord = $winrecord->SELECT('cseo_winrecords.id as wins_id','cseo_winrecords.name','cseo_winrecords.url_win','cseo_winrecords.win_place','cseo_winrecords.status_id','cseo_winrecords.pop','cseo_winrecords.created_at','cseo_statuses.status_name', 'cseo_merchants.merchant_name');

              foreach ($searchwin as $searchwins) {
                     $winrecord->orwhere($searchwins,'like', "%".$search."%")->where('cseo_winrecords.status_id', '9')->where('cseo_winrecords.lang_id', '2')->orwhere($searchwins,'like', "%".$search."%")->where('cseo_winrecords.status_id', '11')->where('cseo_winrecords.lang_id', '2')->orwhere($searchwins,'like', "%".$search."%")->where('cseo_winrecords.status_id', '12')->where('cseo_winrecords.lang_id', '2');
              }
             $winrecord->join('cseo_statuses','cseo_statuses.id', '=', 'cseo_winrecords.status_id')->join('cseo_merchants', 'cseo_merchants.id','=','cseo_winrecords.merchant_id')->orderBy('cseo_winrecords.win_place','asc')->latest(); 

             $query['search'] = request('search');        
        }else{
           
                                                       $winrecord = $winrecord->SELECT('cseo_winrecords.id as wins_id','cseo_winrecords.name','cseo_winrecords.url_win','cseo_winrecords.win_place','cseo_winrecords.status_id','cseo_winrecords.pop','cseo_winrecords.created_at','cseo_statuses.status_name', 'cseo_merchants.merchant_name')->join('cseo_statuses','cseo_statuses.id', '=', 'cseo_winrecords.status_id')->join('cseo_merchants', 'cseo_merchants.id','=','cseo_winrecords.merchant_id')->where('cseo_winrecords.status_id', '9')->where('cseo_winrecords.lang_id', '2')->orwhere('cseo_winrecords.status_id', '12')->where('cseo_winrecords.lang_id', '2')->orderBy('cseo_winrecords.merchant_id', 'desc')->orderBy('cseo_winrecords.win_place','asc')->latest();         

        }  

        $winrecord = $winrecord->paginate(10)->appends($query);
        $win_count = $winrecord->count();

        return view('system.winner.index', compact('winrecord','cseo_wincount','win_count','site_identity'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $merchant = cseo_merchant::where('merchant_name', URL::to('/'))->first();

        $register = cseo_register::SELECT('cseo_registers.id as reg_id', 'cseo_registers.name as reg_name', 'cseo_registers.url_web_contest as reg_url', 'cseo_registers.lang_id','cseo_registers.merchants_id', 'cseo_merchants.merchant_name as merchants', 'cseo_teams.name as language', 'cseo_teams.id as langid','cseo_registers.created_at')->join('cseo_merchants', 'cseo_registers.merchants_id', 'cseo_merchants.id')->join('cseo_teams', 'cseo_teams.id', 'cseo_registers.lang_id')->where('cseo_registers.status_id', '7');

        $registername = $register->latest()->get();

        $register = $register->latest()->paginate(5); 

        $lang = cseo_team::get();

        $merchantlist = cseo_merchant::where('status_id', '9')->latest()->get();

        $title = cseo_options_settings::SELECT('site_identity')->where('merchants_id', $merchant->id)->first();

         if ( count( $title ) > 0 ) {
             $site_identity = json_decode( $title->site_identity);
         }

         return view('system.winner.create', compact('site_identity','merchantlist','lang','register','registername'));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $merchant = cseo_merchant::where('merchant_name', $request->merchant_id)->first();
        
        $winrecord = new cseo_winrecord; 
        
        $winresult = $winrecord::where('win_place', $request->place)->where('merchant_id', $merchant->id)->count();

        if($winresult < 1) {

          $validator = Validator::make($request->all(),[
                //'place' => 'required|unique:cseo_winrecords,win_place',  
                'place' => 'required',  
                'name'=>'required|unique:cseo_winrecords,name',
                'url_win'=>'required',
                'merchant_id'=>'required',
                'lang_id'=>'required',
              ]);

           if ($validator->fails())
            {
                 return Redirect::back()->withErrors($validator)->withInput()->setStatusCode(422);    
                
            }else{


                  $winrecord->win_place = $request->place;
                  $winrecord->name = $request->name;
                  $winrecord->url_win =  $request->url_win;
                  $winrecord->pop = $request->pop;
                  $winrecord->merchant_id = $merchant->id;
                  $winrecord->lang_id = $request->lang_id;
                  $winrecord->status_id = $request->status_id;
                  $winrecord->user_id = Auth::user()->id;
                  
                  $winrecord->save();

                  $lastinsert = $winrecord->id;

                  session()->flash('message', 'Successfully Added');

                  return response()->json(['status'=>'success','message'=>'Successfully Added','id'=>$lastinsert]);
           
             }

        }else{
            session()->flash('message', 'Winner Place Already Added');
            return response()->json(['status'=>'fail','message'=>'Winner Place Already Added']);          
        }

        

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $merchant = cseo_merchant::where('merchant_name', URL::to('/'))->first();

        $lang = cseo_team::get();

        $merchantlist = cseo_merchant::where('status_id', '9')->latest()->get();

        $register = cseo_register::SELECT('cseo_registers.id as reg_id', 'cseo_registers.name as reg_name', 'cseo_registers.url_web_contest as reg_url', 'cseo_registers.lang_id','cseo_registers.merchants_id', 'cseo_merchants.merchant_name as merchants', 'cseo_teams.name as language','cseo_teams.id as langid', 'cseo_registers.created_at')->join('cseo_merchants', 'cseo_registers.merchants_id', 'cseo_merchants.id')->join('cseo_teams', 'cseo_teams.id', 'cseo_registers.lang_id')->where('cseo_registers.status_id', '7');

        $registername = $register->latest()->get();

        $register = $register->latest()->paginate(5); 

        $title = cseo_options_settings::SELECT('site_identity')->where('merchants_id', $merchant->id)->first();

         if ( count( $title ) > 0 ) {
             $site_identity = json_decode( $title->site_identity);
         }

         $winrecord = cseo_winrecord::SELECT('cseo_winrecords.id as wins_id','cseo_winrecords.name','cseo_winrecords.url_win','cseo_winrecords.win_place','cseo_winrecords.pop','cseo_winrecords.created_at','cseo_winrecords.merchant_id','cseo_winrecords.lang_id','cseo_winrecords.status_id')->join('cseo_merchants', 'cseo_merchants.id', 'cseo_winrecords.merchant_id')->join('cseo_teams', 'cseo_teams.id', 'cseo_winrecords.lang_id')->where('cseo_winrecords.id', $id)->where('cseo_winrecords.status_id', '9')->orwhere('cseo_winrecords.id', $id)->where('cseo_winrecords.status_id', '10')->first();


         if(count($winrecord)>0){

             return view('system.winner.edit', compact('winrecord','site_identity','merchantlist','lang','registername','register'));  

         }else{
              session()->flash('message', 'This record cannot be Edited');
              return Redirect('/system/winner');
         }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        
        if($request->moveprocess == "moveSingle" || $request->moveprocess == "moveMulti" ){

                   $win_id = $request->id;
                   $action = $request->action;
                   $curr_action = $request->curr_status;
                
                   if($action=="9" || $action=="10" || $action=="11" ){
                   
                      foreach ($win_id as $ids) 
                      {
                          $winnerfind = cseo_winrecord::where('id', $ids)->first();
                          if($request->moveprocess == "moveMulti"){

                            if($action == "9"){
                                $action_now = $winnerfind->curr_status_id;
                            }else{
                                $action_now = $action;
                            }

                          } else{

                            $action_now = $action;

                          }     
                           //$banner = cseo_winrecord::where('id', $ids)->update(['status_id'=> $action,'curr_status_id'=> $curr_action]);           
                           $winrecord = cseo_winrecord::where('id', $ids)->update(['status_id'=> $action_now,'curr_status_id'=> $winnerfind->status_id]);           
                      
                      }

                       if($action=="11"){
                               $promptmessages = 'Successfully Move to Trash';
                               $lastact = "Trash";
                       }else{
                               $promptmessages = 'Successfully Status Updated';
                               $lastact = "Edit Status";
                       }

                   }else{
                       
                       foreach ($win_id as $ids) 
                       {
                           $winrecord = cseo_winrecord::where('id', $ids)->delete();
                       }

                           $promptmessages = 'Permanently Deleted';
                           $lastact = "Deleted";
                   } 

                    return response()->json(['status'=>'success','message'=> $promptmessages,'lastact' => $lastact]);

                }else{

                     if($request->action=="11"){
                     
                            $winrecord = cseo_winrecord::where('id', $id)->update(['status_id'=> $action,'curr_status_id'=> $curr_action]);
                            session()->flash('message', 'Successfully Move to Trash');
                            return response()->json(['message'=>'Successfully Move to Trash']);     

                     }else{


                         
                         $winrecord = cseo_winrecord::find($id);




                         $merchant = cseo_merchant::where('merchant_name', $request->merchant_id)->first();

                         if($winrecord->win_place == $request->place){


                              $validate = Validator::make($request->all(), [
                                                   //'place' => 'required|unique:cseo_winrecords,win_place',  
                                                   'name'=>'required',
                                                   'url_win'=>'required',
                                                   'place'=>'required',
                                                   'merchant_id'=>'required',
                                                   'lang_id'=>'required',
                                               ]);
                                
                                if ($validate->fails())
                                 {
                                      return Redirect::back()->withErrors($validate)->withInput()->setStatusCode(422); 
                                 }else{  

                                  if( $winrecord->name != $request->name || $winrecord->url_win !=  $request->url_win || $winrecord->pop !=  $request->pop){
                                      $revision = $winrecord->rev_count+1;   
                                  }else {
                                      $revision = $winrecord->rev_count;
                                  }

                                 $winrecord->win_place = $request->place;    
                                 $winrecord->name = $request->name;
                                 $winrecord->url_win =  $request->url_win;
                                 $winrecord->pop =  $request->pop;
                                 $winrecord->rev_count = $revision;
                                 //$winrecord->lang_id = $request->lang_id;
                                 //$winrecord->status_id = $request->status_id;          

                                 $winrecord->save();

                                 $lastinsert = $winrecord->id;

                                  session()->flash('message', 'Successfully Updated');
                                  return response()->json(['status'=>'success','message'=>'Successfully Updated','id'=>$lastinsert]);
                                 }

                         }else{

                            $winresult = cseo_winrecord::where('win_place', $request->place)->where('merchant_id', $merchant->id)->count();
                            

                             if($winresult < 1) {

                               $validate = Validator::make($request->all(), [
                                                    //'place' => 'required|unique:cseo_winrecords,win_place',  
                                                    'name'=>'required',
                                                    'url_win'=>'required',
                                                    'place'=>'required',
                                                    'merchant_id'=>'required',
                                                    'lang_id'=>'required',
                                                ]);
                                 
                                 if ($validate->fails())
                                  {
                                       return Redirect::back()->withErrors($validate)->withInput()->setStatusCode(422); 
                                  }else{  

                                   if( $winrecord->name != $request->name || $winrecord->url_win !=  $request->url_win || $winrecord->pop !=  $request->pop){
                                       $revision = $winrecord->rev_count+1;   
                                   }else {
                                       $revision = $winrecord->rev_count;
                                   }

                                  $winrecord->win_place = $request->place;    
                                  $winrecord->name = $request->name;
                                  $winrecord->url_win =  $request->url_win;
                                  $winrecord->pop =  $request->pop;
                                  $winrecord->rev_count = $revision;
                                  //$winrecord->lang_id = $request->lang_id;
                                  //$winrecord->status_id = $request->status_id;          

                                  $winrecord->save();

                                  $lastinsert = $winrecord->id;

                                   session()->flash('message', 'Successfully Updated');
                                   return response()->json(['status'=>'success','message'=>'Successfully Updated','id'=>$lastinsert]);
                                  }

                             }else{

                              session()->flash('message', 'Winner Place Already Added');
                              return response()->json(['status'=>'fail','message'=>'Winner Place Already Added']);      
                            
                             }

                         }

                         
                          
                        
                     } 

                }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $winrecord = cseo_winrecord::find($id);
        $winrecord->delete();

        session()->flash('message', 'Successfully Deleted');
        return response()->json(['message' => 'Successfully Updated']); 
    }


    public function merchantfilter(Request $request){

        $register = cseo_register::SELECT('cseo_registers.id as reg_id', 'cseo_registers.name as reg_name', 'cseo_registers.url_web_contest as reg_url', 'cseo_registers.lang_id','cseo_registers.merchants_id', 'cseo_merchants.merchant_name as merchants', 'cseo_teams.name as language', 'cseo_teams.id as langid', 'cseo_registers.created_at')->join('cseo_merchants', 'cseo_registers.merchants_id', 'cseo_merchants.id')->join('cseo_teams', 'cseo_teams.id', 'cseo_registers.lang_id')->where('cseo_registers.status_id', '7');

       if($request->ajax()){

          if($request->domain_id == ""){
             
              $registername = $register->latest()->get();

              $register = $register->latest()->paginate(5);

          }else{
             
              $register = $register->where('cseo_merchants.merchant_name', $request->domain_id);

              $registername = $register->latest()->get();

              $register = $register->latest()->paginate(5);
          }

              $data = view('system.winner.ajax-conlist',compact('register'))->render();
              $dataname = view('system.winner.ajax-conlistname',compact('registername'))->render();
    
              return response()->json(['contest_list'=>$data,'contest_listname'=>$dataname]);
      }

    }

    public function searchname(Request $request){

        $register = cseo_register::SELECT('cseo_registers.id as reg_id', 'cseo_registers.name as reg_name', 'cseo_registers.url_web_contest as reg_url', 'cseo_registers.lang_id','cseo_registers.merchants_id', 'cseo_merchants.merchant_name as merchants', 'cseo_teams.name as language', 'cseo_teams.id as langid', 'cseo_registers.created_at')->join('cseo_merchants', 'cseo_registers.merchants_id', 'cseo_merchants.id')->join('cseo_teams', 'cseo_teams.id', 'cseo_registers.lang_id')->where('cseo_registers.status_id', '7');

       if($request->ajax()){

          if($request->merchant == "" && $request->search == ""){
             
              $registername = $register->latest()->get();
              $register = $register->latest()->paginate(5);

          }elseif($request->merchant == "" && $request->search != ""){

              $register = $register->where('cseo_registers.name', $request->search);
              $register = $register->latest()->paginate(5);

          }elseif($request->merchant != "" && $request->search != ""){

             
              $register = $register->where('cseo_merchants.merchant_name', $request->merchant)->where('cseo_registers.name', $request->search);
              
              $register = $register->latest()->paginate(5);
          }

              $data = view('system.winner.ajax-conlist',compact('register'))->render();      
              return response()->json(['contest_list'=>$data]);
      }

    }
}
