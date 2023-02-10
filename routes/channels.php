<?php

use Illuminate\Support\Facades\Broadcast;

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
    return (int) $user->id === (int) $id;
});

Broadcast::channel('home', function() {
    return false;
});

Broadcast::channel('weather-channel.{$user->id}', function ($user, $roomId) {
    return ['id' => $user->id, 'name' => $user->name];
    //    if ($user->canJoinRoom($roomId)) {
//        return ['id' => $user->id, 'name' => $user->name];
//    }
});
