<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ChannelMailerJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var Mailable
     */
    private $mailable;
    /**
     * @var array
     */
    private $configuration;
    /**
     * @var string
     */
    private $to;

    /**
     * Create a new job instance.
     *
     * @param array $configuration
     * @param string $to
     * @param Mailable $mailable
     */
    public function __construct(array $configuration, string $to, Mailable $mailable)
    {
        $this->configuration = $configuration;
        $this->to = $to;
        $this->mailable = $mailable;
    }

    /**
     * Execute the job.
     *
     * @return void
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function handle()
    {
        $mailer = app()->makeWith('channel.mailer', $this->configuration);
        $mailer->to($this->to)->send($this->mailable);
    }
}
