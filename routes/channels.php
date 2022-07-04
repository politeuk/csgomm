<?php

use Illuminate\Support\Facades\Broadcast;
use App\Models\QueuePlayers;

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

Broadcast::channel('queue', function ($user) {
    return $user;
});

Broadcast::channel('queues.{queueId}', function ($user, $queueId) {
    return QueuePlayers::where(['queue_id' => $queueId, 'user_id' => $user->id])->exists();
});
