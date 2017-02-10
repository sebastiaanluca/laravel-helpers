<?php

namespace SebastiaanLuca\Helpers\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class QueueableJob implements ShouldQueue
{
    use InteractsWithQueue, Queueable, SerializesModels;
}
