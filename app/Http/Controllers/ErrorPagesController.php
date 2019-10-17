<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\cseo_merchant;
use App\cseo_options_settings;
 
      

class ErrorPagesController extends Controller
{
    public function accessdenied()
    {

        $merchant = cseo_merchant::where('merchant_name', URL::to('/'))->first();

        $title = cseo_options_settings::SELECT('site_identity')->where('merchants_id', $merchant->id)->first();
        if ( count( $title ) > 0 ) {
            $site_identity = json_decode( $title->site_identity);
        }

    	return view('errors.403', compact('site_identity'));

    }
    public function pagenotfound()
    {

        $merchant = cseo_merchant::where('merchant_name', URL::to('/'))->first();

        $title = cseo_options_settings::SELECT('site_identity')->where('merchants_id', $merchant->id)->first();
        if ( count( $title ) > 0 ) {
            $site_identity = json_decode( $title->site_identity);
        }
    	return view('errors.404', compact('site_identity'));

    }
    public function internalserver()
    {

         $merchant = cseo_merchant::where('merchant_name', URL::to('/'))->first();

        $title = cseo_options_settings::SELECT('site_identity')->where('merchants_id', $merchant->id)->first();
        if ( count( $title ) > 0 ) {
            $site_identity = json_decode( $title->site_identity);
        }

    	return view('errors.500', compact('site_identity'));

    }
}
