<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\OnlineUsers;
use App\Models\Rooms;
use App\Models\UserList;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Http\Request;
use Nette\Utils\Random;
use Illuminate\Support\Carbon;

class AllController extends Controller
{
    public function welcome()
    {
        return view("front.welcome");
    }
    
    
        public function dashboard(Request $request)
        {
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
        return view('front.settings');
    }
    
    public function video(Request $request)
    {
       
        
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
        return view('front.meeting', compact('user'));
    }
    public function text(Request $request)
    {
        $ip = $request->session()->get('ip');
        
        $user =  UserList::where('ip_address', $ip)->first();
        if (empty($user)) {
            return redirect()->route('front.get-started');
        }else{
            UserList::where('id', $user->id)->update([
                "type" => "text",
                "status" => 0
            ]);
        }
        return view('front.text-meeting', compact('user'));
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
        $ip = $request->session()->get('ip');
        $user =  UserList::where('ip_address', $ip)->first();
        UserList::where('id', $user->id)->update([
            "status" => 0
        ]);
        // if ($request->myid != 0 && $request->otherid != 0) {
        //     $old_room = Rooms::where('my_id', $request->myid)->orwhere('other_id', $request->otherid)->first();
        //     if (!empty($old_room)) {
        //         Rooms::destroy($old_room->id);
        //     }
        // }
        $allusers = null;
        if (!empty($user->connect_with)) {
            $allusers = UserList::where('online_status', '>', $time)
                ->where('connect_with', $user->connect_with)
                ->where('status', 0)
                ->orwhere('status', 2)
                ->get();
        } elseif (!empty($user->interest)) {
            $allusers = UserList::where('online_status', '>', $time)
                ->whereIn('interest', $user->interest)
                ->where('status', 0)
                ->orwhere('status', 2)
                ->get();
        } elseif (!empty($user->interest) && !empty($user->connect_with)) {
            $allusers = UserList::where('online_status', '>', $time)
                ->whereIn('interest', $user->interest)
                ->where('connect_with', $user->connect_with)
                ->where('status', 0)
                ->orwhere('status', 2)
                ->get();
        } else {
            $allusers = UserList::where('online_status', '>', $time)
                ->where('status', 0)
                ->orwhere('status', 2)
                ->get();
        }
        foreach ($allusers as $alluser) {
            if (empty(OnlineUsers::where('user_id', $alluser->id)->first())) {
                OnlineUsers::create([
                    'user_id' => $alluser->id
                ]);
            }
        }
        $date = date("Y-m-d");
        $room_name = rand(99999999, 10000000);
       
        while (true) {
            $online_users = $this->all_online_user($user->id,$ip);
            if (count($online_users) >= 2) {
                $other = 0;
                $user1 = $online_users[0]["id"];
                $user2 = $online_users[1]["id"];
                $other = ($user1 != $user->id )? $user1 :(($user2 != $user->id) ? $user2 : 0);
                if ($user1 == $user->id || $user2 == $user->id) {
                    $room = Rooms::where('room_date', $date)->where('my_id', $user->id)->orwhere('other_id', $user->id)->orderBy('created_at', 'desc')->first();
                    if (!empty($room)) {
                        return response()->json(["res" => "success", "room" => $room]);
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
                            return response()->json(["res" => "success", "room" => $room]);
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
        $allusers = null;
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
        $allonline_users = OnlineUsers::inRandomOrder()->limit(2)->get()->toArray();
        return $allusers;
    }
    public function change_status(Request $request)
    {
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
