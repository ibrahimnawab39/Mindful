<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\UserList;
use Illuminate\Http\Request;

class AllController extends Controller
{
    public function welcome()
    {
        return view("front.welcome");
    }
    public function dashboard()
    {
        return view("front.index");
    }
    public function settings()
    {
        return view('front.settings');
    }
    public function store(Request $request)
    {
        $request->validate([
            "nickname" => "required",
            "religion" => "required",
        ]);
        $ip = $_SERVER['REMOTE_ADDR'];
        
       $user =  UserList::where('ip_address',$ip)->first();
       if(!empty($user)){
           UserList::where('id',$user->id)->update([
            "username" => $request->nickname,
            "religion" => $request->religion,
            "status" => 2,
            'ip_address' => $ip
           ]);
       }else{
        UserList::create([
            "username" => $request->nickname,
            "religion" => $request->religion,
            "status" => 2,
            'ip_address' => $ip
        ]);
       }
        return redirect()->route('front.main');
    }
    public function video()
    {
         $ip = $_SERVER['REMOTE_ADDR'];
       $user =  UserList::where('ip_address',$ip)->first();
       if(empty($user)){
           return redirect()->route('front.get-started');
       }
        return view('front.meeting',compact('user'));
    }
    
}
