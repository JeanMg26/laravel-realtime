<?php

namespace App\Http\Controllers;

use App\Events\GreetSend;
use App\Events\MessageSend;
use App\Models\User;
use Illuminate\Http\Request;

class ChatController extends Controller
{
   public function __construct()
   {
      $this->middleware('auth');
   }

   public function showChat()
   {
      return view('chat.show');
   }

   public function messageRecieved(Request $request, User $user)
   {
      $rules = [
         'message' => 'required'
      ];

      $request->validate($rules);

      broadcast(new MessageSend($request->user(), $request->message));

      return response()->json("Greeting");

   }

   public function greetRecieved(Request $request, User $user)
   {

      broadcast(new GreetSend($user, "{$request->user()->name} greeted you"));
      broadcast(new GreetSend($request->user(), "You greeted {$user->name}"));

      return "Greeting {$user->name} from {$request->user()->name}";
   }

}
