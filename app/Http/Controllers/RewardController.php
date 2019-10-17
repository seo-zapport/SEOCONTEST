<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\cseo_options_settings;
use App\cseo_reward;
use App\cseo_merchant;
use App\cseo_team;

use DB;
use URL;
use Validator;
use Redirect;

class RewardController extends Controller
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

        $title = cseo_options_settings::SELECT('site_identity')->where('merchants_id', $merchant->id)->first();

         if ( count( $title ) > 0 ) {
             $site_identity = json_decode( $title->site_identity);
         }

        $query = [];
       //$lang_id = $request->lang_id;
        $lang_id = "1";

        if(request()->has('search')){    
            
        $search = request('search');   

        $reward = cseo_merchant::SELECT(DB::raw('cseo_merchants.merchant_name,cseo_merchants.id, (select amount from cseo_rewards where placereward = '.$lang_id.' and cseo_rewards.merchants_id = cseo_merchants.id and cseo_rewards.lang_id = '.$lang_id.' ) amount_one,(select amount from cseo_rewards where placereward = 2 and cseo_rewards.merchants_id = cseo_merchants.id and cseo_rewards.lang_id = '.$lang_id.' ) amount_two,(select amount from cseo_rewards where placereward = 3 and cseo_rewards.merchants_id = cseo_merchants.id and cseo_rewards.lang_id = '.$lang_id.' ) amount_three'))->where('cseo_merchants.merchant_name', 'like', '%'.$search.'%')->where('cseo_merchants.status_id', '9')->orderBy('cseo_merchants.merchant_name','asc')->latest();

          $query['search'] = request('search');   

        }else{

        $reward = cseo_merchant::SELECT(DB::raw('cseo_merchants.merchant_name,cseo_merchants.id, (select amount from cseo_rewards where placereward = '.$lang_id.' and cseo_rewards.merchants_id = cseo_merchants.id and cseo_rewards.lang_id = '.$lang_id.' ) amount_one,(select amount from cseo_rewards where placereward = 2 and cseo_rewards.merchants_id = cseo_merchants.id and cseo_rewards.lang_id = '.$lang_id.' ) amount_two,(select amount from cseo_rewards where placereward = 3 and cseo_rewards.merchants_id = cseo_merchants.id and cseo_rewards.lang_id = '.$lang_id.' ) amount_three'))->where('cseo_merchants.status_id', '9')->orderBy('cseo_merchants.merchant_name','asc')->latest();

        }

        $reward = $reward->paginate(10)->appends($query);

         return view('system.reward.index', compact('site_identity', 'reward'));
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
        
          $reward = new cseo_reward;

            $validate = Validator::make($request->all(), [
                    //'placereward'=>'required|unique:cseo_rewards',                   
                    'placereward'=>'required',                   
                    ]);
               
            if ($validate->fails()){
                    return Redirect::back()->withErrors($validate)->withInput()->setStatusCode(422);    
            }else{

                $reward->placereward = $request->placereward;
                $reward->amount = $request->amount;
                $reward->merchants_id = $request->merchant;
                $reward->lang_id = $request->lang_id;

                $reward->save();

                //session()->flash('message', 'Successfully Added');
                //return response()->json(['message' => 'Successfully Added']);
                $countrylang = $reward::where('merchants_id', $request->merchant)->where('lang_id', $request->lang_id)->get();

                $data_result = view('system.reward.ajax-rtable',compact('countrylang'))->render();
                $data_popedit = view('system.reward.ajax-popedit',compact('countrylang'))->render();

                return response()->json(array('success' => true, 'rewardtable' => $data_result, 'popedit' => $data_popedit));

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
        
         $lang = cseo_team::get();

        $merchant = cseo_merchant::where('merchant_name', URL::to('/'))->first();

        $title = cseo_options_settings::SELECT('site_identity')->where('merchants_id', $merchant->id)->first();

        if ( count( $title ) > 0 ) {
           $site_identity = json_decode( $title->site_identity);
        }

        $query = [];


        $merchant = cseo_merchant::find($id);

        $reward = cseo_reward::where('merchants_id', $id)->where('lang_id', '1')->get();
    
        return view('system.reward.edit', compact('site_identity','reward', 'merchant','lang'));
        
        
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
       $rewardfind = new cseo_reward;  
       $reward = cseo_reward::find($id);

                  $validate = Validator::make($request->all(), [
                          'placereward'=>'required',                   
                          ]);
                     
                  if ($validate->fails()){
                          return Redirect::back()->withErrors($validate)->withInput()->setStatusCode(422);    
                  }else{

                      $reward->placereward = $request->placereward;
                      $reward->amount = $request->amount;
                      $reward->save();

                     // session()->flash('message', 'Successfully Updated');
                     // return response()->json(['message' => 'Successfully Updated']);
                      $countrylang = $rewardfind::where('merchants_id', $request->merchant)->where('lang_id', $request->lang_id)->get();

                      $data_result = view('system.reward.ajax-rtable',compact('countrylang'))->render();
                      $data_popedit = view('system.reward.ajax-popedit',compact('countrylang'))->render();

                      return response()->json(array('success' => true, 'rewardtable' => $data_result, 'popedit' => $data_popedit));
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
        //
    }
    
    
    public function pageslang(Request $request){

        $reward = new cseo_reward;           


        $countrylang = $reward::where('merchants_id', $request->merchant)->where('lang_id', $request->lang_id)->get();


         if(count($countrylang) > 0) {

            $data_result = view('system.reward.ajax-rtable',compact('countrylang'))->render();
            $data_popedit = view('system.reward.ajax-popedit',compact('countrylang'))->render();
            return response()->json(array('success' => true, 'rewardtable' => $data_result, 'popedit' => $data_popedit));
          
         }else {

            $reward_one = new cseo_reward;
                $reward_one->merchants_id = $request->merchant;
                $reward_one->placereward = '1';
                $reward_one->amount = '0.00';
                $reward_one->lang_id =$request->lang_id;
                $reward_one->save();       
            
            $reward_two = new cseo_reward;
            
                $reward_two->merchants_id = $request->merchant;
                $reward_two->placereward = '2';
                $reward_two->amount = '0.00';
                $reward_two->lang_id =$request->lang_id;
                $reward_two->save();
            
            $reward_three = new cseo_reward;
            
                $reward_three->merchants_id = $request->merchant;
                $reward_three->placereward = '3';
                $reward_three->amount = '0.00';
                $reward_three->lang_id =$request->lang_id;
                $reward_three->save();


            $newcountrylang = $reward::where('merchants_id', $request->merchant)->where('lang_id', $request->lang_id)->get();

            $data_result = view('system.reward.ajax-rtable',compact('newcountrylang'))->render();
            $data_popedit = view('system.reward.ajax-popedit',compact('newcountrylang'))->render();
            return response()->json(array('success' => true, 'rewardtable' => $data_result, 'popedit' => $data_popedit));



         }


    }

}
