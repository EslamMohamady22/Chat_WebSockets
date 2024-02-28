<?php

namespace App\Events;

use App\Models\Message;
use App\Models\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Auth;

class SendMessage implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
public $user;
public $message;
public $id;
public $chat_id;
    /**
     * Create a new event instance.
     */
    public function __construct(User $user , Message $messages ,$id , $chat_id)
    {
        $this->user = $user ;
        $this->message = $messages;
        $this->id = $id;
        $this->chat_id = $chat_id;

    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {

        return [
            new PrivateChannel('chat-channel.'.$this->user->id .'.'.$this->id),
        ];
    }
//     public function broadcastWhen(): bool
// {
//     return auth()->user()->id == $this->id ;
// }
    // public function broadcastOn(): array
    // {

    //     return [
    //         new PrivateChannel('c.'.$this->id),
    //     ];
    // }
    // public function broadcastWhen(){
    //     // check for whatever here
    //     if(Auth::user()->id == '1')
    //     {
    //         return true;
    //     }

    // }
    // public function broadcastWith(): array
    // {
    //     return ['id' => $this->id , 'user'=>$this->user];
    // }
}
