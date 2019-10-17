<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use  App\cseo_register;
use  App\cseo_bank;
use  App\cseo_bank_register;
use App\cseo_options_settings;

class RegistrationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //

        $tax = \Request::path();

        //dd($tax);

        if($tax=="registration") {
            
            $bank = cseo_bank::latest()->get();   
            return view('registration', compact('bank'));

        }else {

            $participants = cseo_register::latest()->get();
            return view('participants', compact('participants'));

        }   



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
        $peronal_data = new cseo_register;

         $this->validate($request,[
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:cseo_registers',
                'mob_no' => 'required|string|max:255',
                'url_permalink' => 'required|string|max:255',
                                       
            ]);

        $peronal_data->name = $request->name;
        $peronal_data->email = $request->email;
        $peronal_data->mobile_number = $request->mob_no;
        $peronal_data->pin_bbm = $request->bbm_pin;
        $peronal_data->url_web_contest = $request->url_permalink;

        $peronal_data->save();

        $lastinsert = $peronal_data->id;

        $bank_data = new cseo_bank_register;

        $bank_data->regsiter_id = $lastinsert;
        $bank_data->bank_id = $request->bank_name;
        $bank_data->account_no = $request->acct_no;
        $bank_data->behalfofaccount = $request->be_acct;
        $bank_data->save();

        return response()->json(['message' => 'Successfully Added']);

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
        //
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
}
