<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\OnlineUsers;
use App\Models\Rooms;
use App\Models\UserList;
use Illuminate\Http\Request;
use Nette\Utils\Random;

class AllController extends Controller
{
    public function welcome()
    {
        return view("front.welcome");
    }
    public function dashboard()
    {
        $ip = $_SERVER['REMOTE_ADDR'];
        $user =  UserList::where('ip_address', $ip)->first();
        if (empty($user)) {
            return redirect()->route('front.get-started');
        }
        return view('front.index', compact('user'));
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
        $user =  UserList::where('ip_address', $ip)->first();
        if (!empty($user)) {
            UserList::where('id', $user->id)->update([
                "username" => $request->nickname,
                "religion" => $request->religion,
                "status" => 2,
                'ip_address' => $ip
            ]);
        } else {
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
        $user =  UserList::where('ip_address', $ip)->first();
        if (empty($user)) {
            return redirect()->route('front.get-started');
        }
        return view('front.meeting', compact('user'));
    }
    public function connect_with(Request $request)
    {
        $ip = $_SERVER['REMOTE_ADDR'];
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
        $ip = $_SERVER['REMOTE_ADDR'];
        $user =  UserList::where('ip_address', $ip)->first();
        UserList::where('id', $user->id)->update([
            "status" => 0
        ]);
        if ($request->myid != 0 && $request->otherid != 0) {
            $old_room = Rooms::where('my_id', $request->myid)->orwhere('other_id', $request->otherid)->first();
            if (!empty($old_room)) {
                Rooms::destroy($old_room->id);
            }
        }
        $allusers = null;
        if (!empty($user->connect_with)) {
            $allusers = UserList::where('online_status', 1)
                ->where('connect_with', $user->connect_with)
                ->where('status', 0)
                ->orwhere('status', 2)
                ->get();
        } elseif (!empty($user->interest)) {
            $allusers = UserList::where('online_status', 1)
                ->whereIn('interest', $user->interest)
                ->where('status', 0)
                ->orwhere('status', 2)
                ->get();
        } elseif (!empty($user->interest) && !empty($user->connect_with)) {
            $allusers = UserList::where('online_status', 1)
                ->whereIn('interest', $user->interest)
                ->where('connect_with', $user->connect_with)
                ->where('status', 0)
                ->orwhere('status', 2)
                ->get();
        } else {
            $allusers = UserList::where('online_status', 1)
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
        // return $this->all_online_user($user->id);
        while (true) {
            $online_users = $this->all_online_user($user->id);
            if (count($online_users) >= 2) {
                $other = 0;
                $user1 = $online_users[0]["id"];
                $user2 = $online_users[1]["id"];
                if ($user1 == $user->id || $user2 == $user2) {
                    $room = Rooms::where('room_date', $date)->where('my_id', $user->id)->orwhere('other_id', $user->id)->orderBy('created_at', 'desc')->first();
                    if (!empty($room)) {
                        return response()->json(["res" => "success", "room" => $room]);
                    } else {
                        Rooms::create([
                            'my_id' => $user1,
                            'other_id' => $user2,
                            'room_date' => $date,
                            'room_name' => $room_name
                        ]);
                        $room = Rooms::where('room_date', $date)->where('my_id', $user->id)->orwhere('other_id', $user->id)->orderBy('created_at', 'desc')->first();
                        return response()->json(["res" => "success", "room" => $room]);
                    }
                    OnlineUsers::where('user_id', $user1)->delete();
                    OnlineUsers::where('user_id', $user2)->delete();
                    exit();
                }
            }
            sleep(1);
        }
    }
    public function all_online_user($id)
    {
        $ip = $_SERVER['REMOTE_ADDR'];
        $user =  UserList::where('ip_address', $ip)->first();
        $allusers = null;
        if (!empty($user->connect_with)) {
            $allusers = UserList::where('online_status', 1)
                ->where('connect_with', $user->connect_with)
                ->where('status', 0)
                ->orwhere('status', 2)
                ->get();
        } elseif (!empty($user->interest)) {
            $allusers = UserList::where('online_status', 1)
                ->whereIn('interest', $user->interest)
                ->where('status', 0)
                ->orwhere('status', 2)
                ->inRandomOrder()
                ->limit(2)
                ->get()
                ->toArray();
        } elseif (!empty($user->interest) && !empty($user->connect_with)) {
            $allusers = UserList::where('online_status', 1)
                ->whereIn('interest', $user->interest)
                ->where('connect_with', $user->connect_with)
                ->where('status', 0)
                ->orwhere('status', 2)
                ->inRandomOrder()
                ->limit(2)
                ->get()
                ->toArray();
        } else {
            $allusers = UserList::where('online_status', 1)
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
        return response()->json(["res" => "success"]);
    }
}
