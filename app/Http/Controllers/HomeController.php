<?php

namespace App\Http\Controllers;

use App\Events\SendMessage;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $users = User::where('id', '!=' , Auth::user()->id )->get();
        return view('home',compact('users'));
    }
    public function chat($id)
    {
        $chat_id = Message::where('user_id',$id)->orwhere('receiver_id',$id)
        ->first();
        if ($chat_id) {
            return view('chat', compact('id','chat_id'));

        }
        else{
            return view('chat', compact('id'));

        }

    }
    public function messages($id)
    {
        $userId = Auth::user()->id;
        return Message::whereIn('user_id', [$userId, $id])
        ->whereIn('receiver_id', [$userId, $id])
        ->with('user')
        ->get();
        // dd($request->id);
    }
    public function messagestore(Request $request)
    {
        // $user = Auth::user();

        // // $messages = new Message();
        // // $messages->message = 'fgf';
        // // $messages->user_id = 1;
        // // $messages->save;
        // $v['user_id'] = 1;
        // $v['message'] = 'hi';
        // DB::table('messages')->insert($v);

        // // $messages = Message::latest()->first();
        // $messages = $user->messages->create([
        //     'message' => $request->message
        // ]);
        // broadcast(new SendMessage($user , $messages))->toOthers();
        // return 'message sent';
        $user = Auth::user();
        $user_id = $user->id;
          $id = $request->receiver_id;
        $target_id = User::where('id',$request->receiver_id)->first();
        // $uid = User::find($id);
        // $user = User::where('id',$request->receiver_id)->first();
// $target_id = 3;
        $messages = $user->messages()->create([
            'message' => $request->message,
            'receiver_id' => $request->receiver_id,
            'chat_id' => $user_id + $id + 20 ,
        ]);
        $chat_id =$user_id + $id;
        broadcast(new SendMessage($user, $messages , $id , $chat_id))->toOthers();
        // broadcast(new SendMessage($user, $messages , $target_id))->onlyTo(function(User $user_id) {
        //     $user_id = User::where('id',2)->first();

        //     // return in_array($user_id->id, $request->receiver_id) ;
        //     return !is_null($user_id);
        // });;

        return 'message sent';
        // return   SendMessage::dispatch($user, $messages , $id , $chat_id);

    }
}
