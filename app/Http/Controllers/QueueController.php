<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Queue;
use App\Models\QueuePlayers;
use App\Jobs\QueuePop;

class QueueController extends Controller
{
    /*
     *
     * QUEUE STATES
     *
     * 0 => PENDING PLAYERS (TYPICALLY 10)
     *
     * 1 => WAITING FOR PLAYERS TO READY UP
     *
     * 2 => CREATED MATCH, THE QUEUE WILL NOW BE DELETED.
     *
     */


    public function join()
    {

        $queue = Queue::where('state', 0)->first();

        $id = ($queue && $queue->users()->count() < 10) ? $queue->id : NULL;

        if (!$id) {
            $queue = Queue::create([
                'state' => 0
            ]);
        }

        $qp = QueuePlayers::updateOrCreate(
            [
                'user_id' => auth()->user()->id,
                'queue_id' => $queue->id,
            ],
            [
                'updated_at' => Carbon::now()->toString(),
                'state' => 0,
            ]
        );

        $id = $qp->queue_id;

         if($queue->users()->count() > 0) {
            QueuePop::dispatch($queue)->delay(now()->addSeconds(1));
            Queue::where('id', $id)->update(['state' => 1, 'updated_at' => Carbon::now()]);
            QueuePlayers::where('queue_id', $id)->update(['state' => 1]);
         }

        return redirect()->back()->with(`id`, $id);

    }

    public function remove(Request $request) {
        QueuePlayers::where('user_id', $request->user()->id)->delete();

        return redirect()->back();
    }

    public function ready(Request $request) {

        QueuePlayers::where('user_id', $request->user()->id)->update(['state' => 2]);
        $qp = QueuePlayers::where('user_id', $request->user()->id)->first();
        $queue = Queue::where('id', $qp->queue_id)->first();
        QueuePop::dispatch($queue)->delay(now());
        return redirect()->back();
    }
}
