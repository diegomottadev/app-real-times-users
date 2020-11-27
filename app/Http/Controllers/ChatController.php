<?php

namespace App\Http\Controllers;

use App\Events\GreetingSent;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Mail\Events\MessageSentEvent;

class ChatController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function show(){
        return view('chat.show');
    }

    public function messageReceived(Request $request){
        $rules = [
            'message' => 'required'
        ];

        $request->validate($rules);

        broadcast(new \App\Events\MessageSentEvent($request->user(), $request->message));

        return response()->json('Message broadcast');
    }

    public function receivedGreet(Request $request, User $user){

        broadcast(new GreetingSent($user,"{$request->user()->name} greated you"));
        broadcast(new GreetingSent($request->user(),"you greated {$user->name}"));

        return "Greeting {$user->name} from {$request->user()->name}";
    }
}
