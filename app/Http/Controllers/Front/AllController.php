<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\ChatBlockWords;
use App\Models\OnlineUsers;
use App\Models\Rooms;
use App\Models\UserList;
use App\Models\BlockUser;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Http\Request;
use Nette\Utils\Random;
use Illuminate\Support\Carbon;

class AllController extends Controller
{
    public function report(Request $req)
    {   
        $blockip = $_SERVER['REMOTE_ADDR'];
         $countIp = count(BlockUser::where('block_ip',$blockip)->get());
        if($countIp >=2){
            
                return redirect()->route('front.blocked');
                exit;
        }
        $pattern = '/Uid=[0-9]+/';
        $my_ip =  $req->session()->get('ip');
        $myid = $req->myid;
        $otherid = $req->otherid;
        
        $user = UserList::where('ip_address', $my_ip)->first();
        if($user->id == $req->myid){ 
            $myid = $req->myid;
            $otherid = $req->otherid; 
             
        }else{  
            $myid = $req->otherid;
            $otherid = $req->myid; 
        }
        
        $user = UserList::where('id', $otherid)->first();
        
        $block_ip = preg_replace($pattern, '', $user->ip_address);
        $my_ip = preg_replace($pattern, '',$my_ip);
        
        $addBlockUser =  BlockUser::create([
            'repoter_ip' =>$my_ip,
            'block_ip' =>$block_ip
        ]);
        
        if($addBlockUser){
             return response()->json(["res" => "success"]);
        }else{
             return response()->json(["res" => "success"]);
        }
        
    }
    
    public function blocked()
    {
       return view("front.blocked");
      
    }
    
    public function rules()
    {
        $blockip = $_SERVER['REMOTE_ADDR'];
         $countIp = count(BlockUser::where('block_ip',$blockip)->get());
        if($countIp >=2){
            
                return redirect()->route('front.blocked');
                exit;
        }
        return view("front.rules");
    }
    
    public function welcome()
    {
        $blockip = $_SERVER['REMOTE_ADDR'];
         $countIp = count(BlockUser::where('block_ip',$blockip)->get());
        if($countIp >=2){
            
                return redirect()->route('front.blocked');
                exit;
        }
        return view("front.welcome");
    }
    
    
        public function dashboard(Request $request)
        {
            $blockip = $_SERVER['REMOTE_ADDR'];
         $countIp = count(BlockUser::where('block_ip',$blockip)->get());
        if($countIp >=2){
            
                return redirect()->route('front.blocked');
                exit;
        }
            Artisan::call('optimize', ['--quiet' => true]);
            $ip =  $request->session()->get('ip');
             
            $user = UserList::where('ip_address', $ip)->first();
    
            if (empty($user)) {
                return redirect()->route('front.get-started');
            }
        
            return view('front.index', compact('user'));
        }
        
        public function store(Request $request)
        {
            $blockip = $_SERVER['REMOTE_ADDR'];
         $countIp = count(BlockUser::where('block_ip',$blockip)->get());
        if($countIp >=2){
            
                return redirect()->route('front.blocked');
                exit;
        }
            $ip = $request->ip();
            $time = time() ; 
       
            $request->validate([
                "nickname" => "required",
                "religion" => "required",
            ]);
            
           
            
            $lastRow = UserList::latest()->first();         
            if (!empty($lastRow)) {
                $lastId = intval($lastRow->id) + 1;
            } else {
                $lastId = 1;
            }
         
            UserList::create([
                "username" => $request->nickname,
                "religion" => $request->religion,
                "online_status" => $time+ 10,
                "status" => '1',
                'ip_address' => $ip . 'Uid=' . $lastId
            ]);
            
            $request->session()->put('ip', $ip . 'Uid=' . $lastId);
           
             return redirect()->route('front.main');
        }
        
    public function updateStatus(Request $request){
        $ip = $request->session()->get('ip');
           $time = time() + 10;
        if (!empty($ip)) { 
              UserList::where('ip_address', $ip)->update(["online_status" => $time]);
        }
    }
        
 
    public function settings()
    {
        $blockip = $_SERVER['REMOTE_ADDR'];
         $countIp = count(BlockUser::where('block_ip',$blockip)->get());
        if($countIp >=2){
            
                return redirect()->route('front.blocked');
                exit;
        }
        return view('front.settings');
    }
    
    public function video(Request $request)
    {
        $blockip = $_SERVER['REMOTE_ADDR'];
         $countIp = count(BlockUser::where('block_ip',$blockip)->get());
        if($countIp >=2){
            
                return redirect()->route('front.blocked');
                exit;
        }
       $blockwords = ChatBlockWords::pluck('block_words')->toArray();
        $ip = $request->session()->get('ip');
        
        $user =  UserList::where('ip_address', $ip)->first();
        if (empty($user)) {
            return redirect()->route('front.get-started');
        }else{
            UserList::where('id', $user->id)->update([
                "type" => "video",
                "status" => 0
            ]);
        }
        return view('front.meeting', compact('user','blockwords'));
    }
    public function text(Request $request)
    {
        $blockip = $_SERVER['REMOTE_ADDR'];
         $countIp = count(BlockUser::where('block_ip',$blockip)->get());
        if($countIp >=2){
            
                return redirect()->route('front.blocked');
                exit;
        }
        $ip = $request->session()->get('ip');
        $blockwords = ChatBlockWords::pluck('block_words')->toArray();
        $user =  UserList::where('ip_address', $ip)->first();
        if (empty($user)) {
            return redirect()->route('front.get-started');
        }else{
            UserList::where('id', $user->id)->update([
                "type" => "text",
                "status" => 0
            ]);
        }
        return view('front.text-meeting', compact('user','blockwords'));
    }
    public function connect_with(Request $request)
    {
        $ip = $request->session()->get('ip');
        $user =  UserList::where('ip_address', $ip)->first();
        if (!empty($user)) {
            UserList::where('id', $user->id)->update([
                'connect_with' => $request->connect_with
            ]);
            return response()->json(["res" => "success", "user" => $user]);
        }
    }
    
    public function skipping(Request $request)
    {
         $time = time();
          $pattern = '/Uid=[0-9]+/';
        $ip = $request->session()->get('ip');
        $user =  UserList::where('ip_address', $ip)->first();
        UserList::where('id', $user->id)->update([
            "status" => 0
        ]);
        
        $date = date("Y-m-d");
        $room_name = rand(99999999, 10000000);
        
        $filtrip = str_replace($pattern,'',$ip);
        
        $blockip = $_SERVER['REMOTE_ADDR'];
        $countIp = count(BlockUser::where('block_ip',$blockip)->get());
      
        if($countIp >=1){
            
                return response()->json(["res" => "ipblocked"]);
                exit;
        }
        
        while (true) {
 
            $online_users = $this->all_online_user($user->id,$ip);
            if (count($online_users) >= 2) {
                $other = 0;
                $user1 = $online_users[0]["id"];
                $user2 = $online_users[1]["id"];
                $other = ($user1 != $user->id )? $user1 :(($user2 != $user->id) ? $user2 : 0);
                $otheruser =  UserList::where('id', $other)->first();
                if ($user1 == $user->id || $user2 == $user->id) {
                    $room = Rooms::where('room_date', $date)->where('my_id', $user->id)->orwhere('other_id', $user->id)->orderBy('created_at', 'desc')->first();
                    if (!empty($room)) {
                            if($user->type == "text"){
                                 UserList::where('id', $user1)->update([
                                    "status" => 1
                                ]);
                                UserList::where('id', $user2)->update([
                                    "status" => 1
                                ]);
                            }
                        return response()->json(["res" => "success", "room" => $room,"other_username"=>$otheruser->username]);
                    } else {
                    $room = Rooms::where('room_date', $date)->where('my_id', $other)->orwhere('other_id', $other)->orderBy('created_at', 'desc')->first();
                    if (empty($room)) {
                            Rooms::create([
                                'my_id' => $user1,
                                'other_id' => $user2,
                                'room_date' => $date,
                                'room_name' => $room_name
                            ]);
                            $room = Rooms::where('room_date', $date)->where('my_id', $user->id)->orwhere('other_id', $user->id)->orderBy('created_at', 'desc')->first();
                            OnlineUsers::where('user_id', $user1)->delete();
                            OnlineUsers::where('user_id', $user2)->delete();
                            return response()->json(["res" => "success", "room" => $room,"other_username"=>$otheruser->username]);
                        }
                        exit();
                    }
                }
            }
            sleep(1);
        }
    }
    public function all_online_user($id,$ip)
    {   
          $time = time();
        
        $user =  UserList::where('ip_address', $ip)->first();
        $allusers = array();
        if (!empty($user->connect_with)) {
            $allusers =  UserList::where('online_status', '>', $time)
                ->where('connect_with', $user->connect_with)
                ->where('type',$user->type)
                ->where('status', 0)
                ->orwhere('status', 2)
                ->get();
        } elseif (!empty($user->interest)) {
            $allusers =  UserList::where('online_status', '>', $time)
                ->whereIn('interest', $user->interest)
                ->where('type',$user->type)
                ->where('status', 0)
                ->orwhere('status', 2)
                ->inRandomOrder()
                ->limit(2)
                ->get()
                ->toArray();
        } elseif (!empty($user->interest) && !empty($user->connect_with)) {
            $allusers =  UserList::where('online_status', '>', $time)
                ->whereIn('interest', $user->interest)
                ->where('connect_with', $user->connect_with)
                ->where('type',$user->type)
                ->where('status', 0)
                ->orwhere('status', 2)
                ->inRandomOrder()
                ->limit(2)
                ->get()
                ->toArray();
        } else {
            $allusers = UserList::where('online_status', '>', $time)
                ->where('type',$user->type)
                ->where('status', 0)
                ->orwhere('status', 2)
                ->inRandomOrder()
                ->limit(2)
                ->get()
                ->toArray();
        }
        // $allonline_users = OnlineUsers::inRandomOrder()->limit(2)->get()->toArray();
        return $allusers;
    }
    public function change_status(Request $request)
    {
        $ip = $request->session()->get('ip');
        $user =  UserList::where('ip_address', $ip)->first();
        $other = (($user->id != $request->myid)? $request->myid : (($user->id != $request->otherid) ? $request->otherid : 0) );
        // echo $other;
        // exit();
        if($user->type == "text") {
            $other_user = UserList::where('id',$other)->where('status',1)->first();
            if(!empty($other_user)){
                    if ($request->myid != 0 && $request->otherid != 0) {
                    $old_room = Rooms::where('my_id', $request->myid)->orwhere('other_id', $request->otherid)->first();
                    if (!empty($old_room)) {
                        Rooms::destroy($old_room->id);
                    }
                }
                return response()->json(["res" => "success"]);
            }else{
                return response()->json(["res" => "error"]);
            }
        }else{
            UserList::where('id', $request->myid)->update([
                "status" => 1
            ]);
            UserList::where('id', $request->otherid)->update([
                "status" => 1
            ]);
            if ($request->myid != 0 && $request->otherid != 0) {
                $old_room = Rooms::where('my_id', $request->myid)->orwhere('other_id', $request->otherid)->first();
                if (!empty($old_room)) {
                    Rooms::destroy($old_room->id);
                }
            }
            return response()->json(["res" => "success"]);
        }
    }
    public function change_intrest(Request $request)
    {
        $ip = $_SERVER['REMOTE_ADDR'];
        $user =  UserList::where('ip_address', $ip)->first();
        if (!empty($user)){
            UserList::where('id', $user->id)->update([
                "interest" => $request->intrest
            ]);
            return response()->json(["res" => "success"]);
        }
    }
}
