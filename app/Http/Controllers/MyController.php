<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Offer;
use DB;

class MyController extends Controller
{
    public function company(User $item) {
        $company = DB::table('companies')->where('user_id','=',$item->id)->first();
        $offers = DB::table('offers')->where('created_by','=',$item->id)->get();
        $last_offer = DB::table('offers')->where('created_by','=',$item->id)->orderby('id','desc')->first();
        $latest_offers = DB::table('offers')->where('created_by','=',$item->id)->orderby('id','desc')->offset(1)->limit(4)->get();
        
        return view('company',  compact('item','company','offers','last_offer','latest_offers'));
    }
    public function offer(Offer $item) {
        $company = DB::table('companies')->where('user_id','=',$item->created_by)->first();
        $user = DB::table('users')->where('id','=',$item->created_by)->first();
        $offers = DB::table('offers')->where('created_by','=',$item->created_by)->get();
        return view('offer',  compact('item','company','user','offers'));
    }
}
