<?php

namespace App\Jobs;

use App\Events\NotifyNewRowCreated;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class UpdateFileParsingProgress implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $counter;

    /**
     * Create a new job instance.
     *
     * @param int $counter
     */
    public function __construct(int $counter)
    {
        $this->counter = $counter;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        event(new NotifyNewRowCreated(['counter' => $this->counter]));
    }
}
