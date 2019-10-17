<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


use App\cseo_account;
use App\cseo_bank;
use App\cseo_team;
use App\cseo_merchant;
use App\cseo_options_settings;

use DB;
use URL;
use Validator;
use Redirect;



class BankController extends Controller
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
            
            if($this->user->status_id != '4'){
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
        $merchant = cseo_merchant::where('merchant_name', URL::to('/'))->first();
        $bank = new cseo_bank;
        $lang = cseo_team::where('locale','<>','EN')->latest()->get();

        $query = [];
        $searchbrand = ['cseo_banks.name','cseo_banks.bank_acronym'];   

        if(request()->has('search')){

            $search = request('search');    
            $query['search'] = $search;
            
            $bank = $bank::SELECT(DB::raw('cseo_banks.id,cseo_banks.name,cseo_banks.bank_acronym,cseo_teams.id as lang_id,cseo_teams.name as lang_name'));

              foreach ($searchbrand as $searchbrands) {

                $bank->orwhere($searchbrands, 'LIKE', "%".$search."%")->where('cseo_categories.status_id', '9');
                
              } 

            $bank->join('cseo_teams','cseo_teams.id','=','cseo_banks.lang_id')->orderBy('cseo_banks.created_at', 'asc');   

        }else{

            $bank = $bank::SELECT(DB::raw('cseo_banks.id,cseo_banks.name,cseo_banks.bank_acronym,cseo_teams.id as lang_id,cseo_teams.name as lang_name'))->join('cseo_teams','cseo_teams.id','=','cseo_banks.lang_id')->orderBy('cseo_banks.created_at', 'asc');
            
        }
        
        $bank = $bank->paginate(10)->appends($query);
        $bank_count = $bank->count();

        $title = cseo_options_settings::SELECT('site_identity')->where('merchants_id', $merchant->id)->first();

         if ( count( $title ) > 0 ) {
             $site_identity = json_decode( $title->site_identity);
         }

        return view('system.settings.bank.index', compact('bank','bank_count','lang','site_identity'));
        
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
        $validate = Validator::make($request->all(), [
                'bname'=>'required|unique:cseo_banks',                   
                ]);

        $bank = new cseo_bank;

        if ($validate->fails()){
                return Redirect::back()->withErrors($validate)->withInput()->setStatusCode(422);    
        }else{


            $bank->name = $request->bname;
            $bank->bank_acronym = $request->bacronym;
            $bank->lang_id = $request->langid;
            $bank->save();            

            session()->flash('message', 'Successfully Added');
            return response()->json(['message' => 'Successfully Added']);

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
        

        $bank = cseo_bank::find($id);

         $validate = Validator::make($request->all(), [
                    'bname'=>'required',                   
                    'bacronym'=>'required',                   
                ]);
           
          if ($validate->fails())
           {
                return Redirect::back()->withErrors($validate)->withInput()->setStatusCode(422);    
               
           }else{

                $bank->name = $request->bname;
                $bank->bank_acronym = $request->bacronym;
                $bank->lang_id = $request->langid;
                $bank->save();

                session()->flash('message', 'Successfully Updated');
                return response()->json(['message' => 'Successfully Updated']);

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
        $bank = cseo_bank::find($id);
        $bank->delete();

        session()->flash('message', 'Successfully Deleted');
        return response()->json(['message' => 'Successfully Deleted']);
    }
}
