<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\cseo_register;
use App\cseo_bank;
use App\cseo_bank_register;
use App\cseo_statuses;
use App\cseo_options_settings;
use App\cseo_merchant;

use DB;
use URL;
use Validator;
use Redirect;
use Excel;

class ContestController extends Controller
{
     /**
         * Create a new controller instance.
         *
         * @return void
         */
        public function __construct()
        {
            $this->middleware('auth');
            $this->middleware('logged');          
        }

    /**
      * Display a listing of the resource.
      *
      * @return \Illuminate\Http\Response
      */
    public function index()
    {

        $merchant = cseo_merchant::where('merchant_name', URL::to('/'))->first();

        $register = new cseo_register;

        $bank = cseo_bank::latest()->get();
        $status = cseo_statuses::where('status_name',"!=",'New')->where('level_id', '2')->latest()->get();

        $cseo_contest_count = $register->SELECT(DB::raw("(SELECT count(*) from cseo_registers) countAll, (SELECT count(*) from cseo_registers where status_id = '6') countPending, (SELECT count(*) from cseo_registers where status_id = '7') countApproved, (SELECT count(*) from cseo_registers where status_id = '8') countDisqualified, (SELECT count(*) from cseo_registers where status_id = '11') countTrash"))->first(); 
    
        $query = []; 
        $searchregister = ['cseo_registers.name','cseo_registers.email', 'cseo_registers.mobile_number','cseo_registers.url_web_contest','cseo_registers.verify_status','cseo_statuses.status_name','cseo_banks.name', 'cseo_merchants.merchant_name'];

        if(request()->has('search') && request()->has('status_id')){            

         $search = request('search');    
         $statusid = request('status_id');    
         
              $register = $register->Select(DB::raw("cseo_banks.name as bname, cseo_bank_registers.register_id, cseo_bank_registers.bank_id, cseo_bank_registers.account_no, cseo_bank_registers.behalfofaccount, cseo_registers.name as rname, cseo_registers.email, cseo_registers.mobile_number, cseo_registers.pin_bbm, cseo_registers.url_web_contest, cseo_registers.created_at, cseo_bank_registers.id, cseo_statuses.status_name, cseo_registers.verify_status, cseo_registers.id as reg_id, cseo_registers.status_id, cseo_registers.curr_status_id,cseo_merchants.merchant_name, cseo_teams.name"));
              
          foreach ($searchregister as $searchregisters) {
                 $register->orwhere($searchregisters,'like', "%".$search."%")->where('cseo_registers.status_id',$statusid);
          }

          $register->join('cseo_bank_registers','cseo_registers.id','=','cseo_bank_registers.register_id')->join('cseo_banks','cseo_banks.id','=','cseo_bank_registers.bank_id')->join('cseo_statuses', 'cseo_statuses.id', '=','cseo_registers.status_id')->join('cseo_merchants', 'cseo_merchants.id','=','cseo_registers.merchants_id')->join('cseo_teams', 'cseo_teams.id','cseo_registers.lang_id')->orderBy('cseo_statuses.id', 'asc')->orderBy('cseo_registers.verify_status', 'asc')->orderBy('cseo_merchants.id', 'asc')->latest(); 

          $query['search'] = request('search'); 
          $query['status_id'] = request('status_id'); 
        

         }elseif(request()->has('status_id')){
        
           $register = $register->Select(DB::raw("cseo_banks.name as bname, cseo_bank_registers.register_id, cseo_bank_registers.bank_id, cseo_bank_registers.account_no, cseo_bank_registers.behalfofaccount, cseo_registers.name as rname, cseo_registers.email, cseo_registers.mobile_number, cseo_registers.pin_bbm, cseo_registers.url_web_contest, cseo_registers.created_at, cseo_bank_registers.id, cseo_statuses.status_name, cseo_registers.verify_status, cseo_registers.id as reg_id, cseo_registers.status_id, cseo_registers.curr_status_id,cseo_merchants.merchant_name, cseo_teams.name"))->join('cseo_bank_registers','cseo_registers.id','=','cseo_bank_registers.register_id')->join('cseo_banks','cseo_banks.id','=','cseo_bank_registers.bank_id')->join('cseo_statuses', 'cseo_statuses.id', '=','cseo_registers.status_id')->join('cseo_merchants', 'cseo_merchants.id','=','cseo_registers.merchants_id')->join('cseo_teams', 'cseo_teams.id','cseo_registers.lang_id')->where('cseo_registers.status_id', request('status_id'))->orderBy('cseo_statuses.id', 'asc')->orderBy('cseo_registers.verify_status', 'asc')->orderBy('cseo_merchants.id', 'asc')->latest();    
           
           $query['status_id'] = request('status_id');


         }elseif(request()->has('search')){

              $search = request('search');    
              
              $register = $register->Select(DB::raw("cseo_banks.name as bname, cseo_bank_registers.register_id, cseo_bank_registers.bank_id, cseo_bank_registers.account_no, cseo_bank_registers.behalfofaccount, cseo_registers.name as rname, cseo_registers.email, cseo_registers.mobile_number, cseo_registers.pin_bbm, cseo_registers.url_web_contest, cseo_registers.created_at, cseo_bank_registers.id, cseo_statuses.status_name, cseo_registers.verify_status, cseo_registers.id as reg_id, cseo_registers.status_id, cseo_registers.curr_status_id,cseo_merchants.merchant_name, cseo_teams.name"));

              foreach ($searchregister as $searchregisters) {
                     $register->orwhere($searchregisters,'like', "%".$search."%")->where('cseo_registers.status_id', '6')->orwhere($searchregisters,'like', "%".$search."%")->where('cseo_registers.status_id', '7')->orwhere($searchregisters,'like', "%".$search."%")->where('cseo_registers.status_id', '8');
              }

              $register->join('cseo_bank_registers','cseo_registers.id','=','cseo_bank_registers.register_id')->join('cseo_banks','cseo_banks.id','=','cseo_bank_registers.bank_id')->join('cseo_statuses', 'cseo_statuses.id', '=','cseo_registers.status_id')->join('cseo_merchants', 'cseo_merchants.id','=','cseo_registers.merchants_id')->join('cseo_teams', 'cseo_teams.id','cseo_registers.lang_id')->orderBy('cseo_statuses.id', 'asc')->orderBy('cseo_registers.verify_status', 'asc')->orderBy('cseo_merchants.id', 'asc')->latest();
              $query['search'] = request('search');


        }elseif(request()->has('export')){      

              $req_export = request('export'); 
              $this->getExportExcel($req_export);
                     
        }else{
             $register = $register->Select(DB::raw("cseo_banks.name as bname, cseo_bank_registers.register_id, cseo_bank_registers.bank_id, cseo_bank_registers.account_no, cseo_bank_registers.behalfofaccount, cseo_registers.name as rname, cseo_registers.email, cseo_registers.mobile_number, cseo_registers.pin_bbm, cseo_registers.url_web_contest, cseo_registers.created_at, cseo_bank_registers.id, cseo_statuses.status_name, cseo_registers.verify_status, cseo_registers.id as reg_id, cseo_registers.status_id, cseo_registers.curr_status_id,cseo_merchants.merchant_name, cseo_teams.name"))->join('cseo_bank_registers','cseo_registers.id','=','cseo_bank_registers.register_id')->join('cseo_banks','cseo_banks.id','=','cseo_bank_registers.bank_id')->join('cseo_statuses', 'cseo_statuses.id', '=','cseo_registers.status_id')->join('cseo_merchants', 'cseo_merchants.id','=','cseo_registers.merchants_id')->join('cseo_teams', 'cseo_teams.id','cseo_registers.lang_id')->where('cseo_registers.status_id', '6')->orwhere('cseo_registers.status_id', '7')->orwhere('cseo_registers.status_id', '8')->orderBy('cseo_statuses.id', 'asc')->orderBy('cseo_registers.verify_status', 'asc')->orderBy('cseo_merchants.id', 'asc')->latest();
        }

        $register = $register->paginate(10)->appends($query);
        $con_count = $register->count();

       $title = cseo_options_settings::SELECT('site_identity')->where('merchants_id', $merchant->id)->first();

        if ( count( $title ) > 0 ) {
            $site_identity = json_decode( $title->site_identity);
        }        
       
        return view('system.contestant.index', compact('cseo_contest_count','register','con_count', 'bank','status','site_identity'));


    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
        //
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

          $ban_id = $request->id;
          $action = $request->action;
          $curr_action = $request->curr_status;
       
          if($action=="11" || $action=="6" || $action=="7" || $action=="8" || $action=="9"){
          
             foreach ($ban_id as $ids) 
             {

                  $registerfind = cseo_register::where('id', $ids)->first();

                  if($action == '9'){
                      $action_now = $registerfind->curr_status_id;
                      $curr_now = $registerfind->status_id;
                  }else{
                      $action_now = $action;
                      $curr_now = $registerfind->status_id;
                  }
                  $register = cseo_register::where('id', $ids)->update(['status_id'=> $action_now,'curr_status_id'=> $curr_now]);               
             }

              if($action=="11"){
                      $promptmessages = 'Successfully Move to Trash';
                      $lastact = "Trash";
              }elseif($action=="6" || $action=="7" || $action=="8"){
                      $promptmessages = 'Successfully Restore';
                      $lastact = "Restore";
              }else{
                      $promptmessages = 'Successfully Updated Status';
                      $lastact = "Edit Status";
              }

          }else{
              
              foreach ($ban_id as $ids) 
              {
                  $register = cseo_register::where('id', $ids)->delete();
                  $bankregister = cseo_bank_register::where('register_id', $ids)->delete();
              }

                  $promptmessages = 'Permanently Deleted';
                  $lastact = "Deleted";
          } 

           return response()->json(['status'=>'success','message'=> $promptmessages,'lastact' => $lastact]);

       }else{

            if($request->action=="11"){
            
                   $register = cseo_register::where('id', $id)->update(['status_id'=> $action,'curr_status_id'=> $curr_action]);
                   session()->flash('message', 'Successfully Move to Trash');
                   return response()->json(['message'=>'Successfully Move to Trash']);     

            }else{
                
                 $banner = cseo_register::find($id);

                  $validate = Validator::make($request->all(), [
                                'name' => 'required',
                                'email' => 'required',
                                'mob_no' => 'required',
                                'bbm_pin' => 'required',
                                'url_permalink' => 'required',
                                'bank_name' => 'required',
                                'acct_no'  => 'required',
                                'be_acct' => 'required',
                                'action' => 'required',

                                 ]);
                  
                  if ($validate->fails())
                   {
                      return Redirect::back()->withErrors($validate)->withInput()->setStatusCode(422); 
                   }else{  

                    $banner->name = $request->name;
                    $banner->email = $request->email;
                    $banner->mobile_number = $request->mob_no;
                    $banner->pin_bbm = $request->bbm_pin;
                    $banner->url_web_contest = $request->url_permalink;
                    $banner->status_id = $request->action;

                    $banner->save();

                    $lastinsert = $banner->id;

                    $bank_data = cseo_bank_register::where('register_id', $banner->id)->update(['bank_id' => $request->bank_name , 'account_no' => $request->acct_no, 'behalfofaccount' => $request->be_acct ]);

                   
                    session()->flash('message', 'Successfully Updated');
                    return response()->json(['status'=>'success','message'=>'Successfully Updated','id'=>$lastinsert]);
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
         $register = cseo_register::where('id', $id)->delete();
         $bankregister = cseo_bank_register::where('register_id', $id)->delete();
           session()->flash('message', 'Successfully delete');
           return response()->json(['status'=>'success','message'=>'Successfully Deleted']);
    }


    /**
     * Create new xlsx File.
     *
     * @param  string  $requst
     * @return \Illuminate\Http\Response
     */
       
    public function getExportExcel($req_export) {

    $export = new cseo_register;

    if($req_export == "All"){
    
    $export = $export->Select(DB::raw("cseo_banks.name as bname, 
      cseo_bank_registers.register_id,
      cseo_bank_registers.bank_id,
      cseo_bank_registers.account_no,
      cseo_bank_registers.behalfofaccount,
      cseo_registers.name as rname,
      cseo_registers.email,
      cseo_registers.mobile_number,
      cseo_registers.url_web_contest,
      cseo_registers.created_at,
      cseo_statuses.status_name,
      cseo_merchants.merchant_name,
      cseo_teams.name"))
      ->join('cseo_bank_registers','cseo_registers.id','=','cseo_bank_registers.register_id')
      ->join('cseo_banks','cseo_banks.id','=','cseo_bank_registers.bank_id')
      ->join('cseo_statuses', 'cseo_statuses.id', '=','cseo_registers.status_id')
      ->join('cseo_merchants', 'cseo_merchants.id','=','cseo_registers.merchants_id')
      ->join('cseo_teams', 'cseo_teams.id','cseo_registers.lang_id')
      ->orderBy('cseo_statuses.id', 'asc')->orderBy('cseo_merchants.id', 'asc')->get();
      }else{
      $export = $export->Select(DB::raw("cseo_banks.name as bname, 
      cseo_bank_registers.register_id,
      cseo_bank_registers.bank_id,
      cseo_bank_registers.account_no,
      cseo_bank_registers.behalfofaccount,
      cseo_registers.name as rname,
      cseo_registers.email,
      cseo_registers.mobile_number,
      cseo_registers.url_web_contest,
      cseo_registers.created_at,
      cseo_statuses.status_name,
      cseo_merchants.merchant_name,
      cseo_teams.name"))
      ->join('cseo_bank_registers','cseo_registers.id','=','cseo_bank_registers.register_id')
      ->join('cseo_banks','cseo_banks.id','=','cseo_bank_registers.bank_id')
      ->join('cseo_statuses', 'cseo_statuses.id', '=','cseo_registers.status_id')
      ->join('cseo_merchants', 'cseo_merchants.id','=','cseo_registers.merchants_id')
      ->join('cseo_teams', 'cseo_teams.id','cseo_registers.lang_id')
      ->where('cseo_statuses.status_name', $req_export)->get();        
      }

    $formArray = [];
    $isError = false;

    if ( count( $export ) > 0 ) {

      $formArray[] = ['No', 'Merchant', 'Language', 'Name', 'Email', 'URL Website Constest', 'Mobile no.', 'Bank Name', 'Account no.', 'Behalf of Account' , 'Date Registered', 'Status'];
      $count = 1;
       $date = date('Y/m/d');

      foreach ($export as $export_new ) {
        //$formArray[] = $export_new->toArray();
        $formArray[] = [
          $count,
          $export_new->merchant_name,
          $export_new->name,
          $export_new->rname,
          $export_new->email,
          $export_new->url_web_contest,
          $export_new->mobile_number,
          $export_new->bname,
          $export_new->account_no,
          $export_new->behalfofaccount,
          $export_new->created_at,
          $export_new->status_name

        ];
        $count++;
      }

        Excel::create($req_export . '-report-'.$date, function($excel) use($formArray) {
          $excel->setTitle( 'Report' );
          $excel->setCreator('SEO Dept.')->setCompany('Zapport Services Inc');
          $excel->setDescription('Report files');
          $excel->sheet('sheet 1', function($sheet) use($formArray) {
            $range = "1";
            $sheet->setAllBorders('thin');
            $sheet->cells($range, function($cells) {
                $cells->setFontWeight('bold');
                $cells->setAlignment('center');
          });
            $sheet->fromArray($formArray, null, 'A1', true, false);
          });
        })->export('xlsx');
        return Redirect::back();
      }else{
      $isError = true;
    }

    if ($isError) {
      return view('errors.table');
    }

    }    



}
