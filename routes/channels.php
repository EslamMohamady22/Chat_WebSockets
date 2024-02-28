<?php

use App\Models\Message;
use App\Models\User;
use Hamcrest\Core\IsNull;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Broadcast;
use App\Broadcasting\Channel;

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    // $user = Auth::user();
    // return (int) $user->id === (int) $id;
    // $userid = User::find(2);

    // return $userid;
    return Auth::check();

});
Broadcast::channel('chat-channel.{id}.{user_id}', function( $id) {
    return Auth::check();
    // $userid = User::find($id);
    // $userid = User::where('id',$id)->first()->exists();
    // return Auth::user()->id === $id ;


    // return $userid;
        // return (int) $user->id === (int) $id;

});
Broadcast::channel('c.{id}', function (User $user, $id) {
    // $targetid = Message::where('user_id','2')->first();
    // $userid = User::where('id',$target_id)->first();
    // // return $user->id == $targetid->user_id || $user->id == $targetid->receiver_id;
    // return $user->id == $ticket->asked_user_id || $user->id == $ticket->responded_user_id;
    // return $userid !== null ;

    // return (int) $user->id == (int) $id;
//     if(Auth::user()->id === 1)
// {
//     // $profile = $user->Profile;

//     // $data = [
//     //     'id' => $user->id,
//     //     // 'name' => $user->name,
//     //     // 'username' => $user->username,
//     //     // 'avatar' => config('app.storage').$profile->profile_image,
//     //     // 'url' => $profile->profile_url,
//     //     // 'favorite_bible_verse' => $profile->favorite_bible_verse,
//     //     // 'worships_id' => $id
//     // ];

    // return true;
// }
// $v =  Message::where('user_id',$id)->latest()->first();
// $u = Auth::user()->id;
// return (int) $user->id === (int) $id;

return Auth::check();
// $uid = Auth::user()->id;
// return User::where('id', $uid)->exists();
// return Message::latest()->first()->where('receiver_id', $uid)->exists();
});
// Broadcast::channel('messages.{id}', function (User $user, Message $message ) {
//     $participantIds = $chat->receiver_id->pluck('receiver_id');

//     return $participantIds->contains($user->getKey());
// });
Broadcast::channel('corder.{id}', Channel::class);
