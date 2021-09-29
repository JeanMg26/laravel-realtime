<?php

namespace App\Events;

use App\Models\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class MessageSend implements ShouldBroadcast
{
   use Dispatchable, InteractsWithSockets, SerializesModels;

   public $user;
   public $message;
   // public $auth;

   /**
    * Create a new event instance.
    *
    * @return void
    */
   public function __construct(User $user, $message)
   {
      $this->user    = $user;
      $this->message = $message;
      // $this->auth    = auth()->user();
   }

   /**
    * Get the channels the event should broadcast on.
    *
    * @return \Illuminate\Broadcasting\Channel|array
    */
   public function broadcastOn()
   {
      // Log::debug("{$this->auth->name} - {$this->user->name} : {$this->message}");
      return new PresenceChannel('chat');
   }
}
