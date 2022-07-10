<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Events\QueuePop as QPE;

class QueuePop implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(public \App\Models\Queue $q)
    {
        $q->load('users');
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // if($this->q->users->count() > 9) {
            info('job');
            QPE::dispatch($this->q);
        // }
    }
}
